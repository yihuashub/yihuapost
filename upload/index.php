<?php
include_once ('../config/config.php');
$options = array(
    'delete_type' => 'POST',
    'db_host' => DB_SERVER,
    'db_user' => DB_USERNAME,
    'db_pass' => DB_PASSWORD,
    'db_name' => DB_DATABASE,
    'db_table' => 'image_files'
);

error_reporting(E_ALL | E_STRICT);
require('UploadHandler.php');

class CustomUploadHandler extends UploadHandler {

    protected function initialize() {
        $this->db = mysqli_connect(
            $this->options['db_host'],
            $this->options['db_user'],
            $this->options['db_pass'],
            $this->options['db_name']
        );

        /* check connection */
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }

        /* change character set to utf8 */
        if (!$this->db->set_charset("utf8")) {
            printf("Error loading character set utf8: %s\n", $this->db->error);
        }

        parent::initialize();
        $this->db->close();
    }

    protected function handle_form_data($file, $index) {
        $file->title = @$_REQUEST['title'][$index];
        $file->description = @$_REQUEST['description'][$index];
        $file->id = @$_REQUEST['id'][$index];
        $file->pid = @$_REQUEST['pid'][$index];

    }

    protected function handle_file_upload($uploaded_file, $name, $size, $type, $error,
                                          $index = null, $content_range = null) {
        $file = parent::handle_file_upload(
            $uploaded_file, $name, $size, $type, $error, $index, $content_range
        );
        if (empty($file->error)) {
            $sql = 'INSERT INTO `'.$this->options['db_table']
                .'` (`name`, `size`, `type`, `title`, `pid`,`description`)'
                .' VALUES (?, ?, ?, ?, ?, ?)';
            $query = $this->db->prepare($sql);
            $query->bind_param(
                    'sissss',
                $file->name,
                $file->size,
                $file->type,
                $file->title,
                $file->pid,
                $file->description
            );
            $query->execute();
            $file->id = $this->db->insert_id;
        }
        return $file;
    }

    protected function set_additional_file_properties($file) {
        parent::set_additional_file_properties($file);
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $sql = 'SELECT `id`, `type`, `title`, `description` , `pid` FROM `'
                .$this->options['db_table'].'` WHERE `name`=?';
            $query = $this->db->prepare($sql);
            $query->bind_param('s', $file->name);
            $query->execute();
            $query->bind_result(
                $id,
                $type,
                $title,
                $description,
                $pid
            );
            while ($query->fetch()) {
                $file->id = $id;
                $file->type = $type;
                $file->title = $title;
                $file->description = $description;
                $file->pid = $pid;
            }
        }
    }

    public function delete($print_response = true) {
        $response = parent::delete(false);
        foreach ($response as $name => $deleted) {
            if ($deleted) {
                $sql = 'DELETE FROM `'
                    .$this->options['db_table'].'` WHERE `name`=?';
                $query = $this->db->prepare($sql);
                $query->bind_param('s', $name);
                $query->execute();
            }
        }
        return $this->generate_response($response, $print_response);
    }

}

$upload_handler = new CustomUploadHandler($options);