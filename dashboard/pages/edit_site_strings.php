<?php
/**
 * Copyright (C) 2018-2019 yihua. MIT License
 * User: Yihua
 * Date: 12/14/2017
 * Time: 8:55 PM
 */


if (isset($_POST))
{
    $newString =  $_POST;

    $doc = new DOMDocument('1.0');
    $doc->formatOutput = true;

    foreach ($newString as $key => $value) {

        $root = $doc->createElement('string');
        $root = $doc->appendChild($root);

        $keyString = $doc->createElement('key');
        $title = $root->appendChild($keyString);

        $text = $doc->createTextNode($key);
        $text = $title->appendChild($text);

        $valueString = $doc->createElement('value');
        $title1 = $root->appendChild($valueString);

        $text1 = $doc->createTextNode($value);
        $text1 = $title1->appendChild($text1);

    }

    $doc->save('test1.xml'); // save as file
}else{



    $langArray = array(
        "navbarString1" => "首页",
        "navbarString2" => "最新房源",
        "navbarString3" => "经纪团队",
        "navbarString4" => "地产文章",
        "navbarString5" => "关于我们",
        "navbarString6" => "请输入房源关键词",
        "navbarString7" => "搜索：",


        "error404String1" => "啊哦！",
        "error404String2" => "404错误",
        "error404String3" => "抱歉，此页面不存在。",
        "error404String4" => "返回主页",

        "homeString1" => "最新房源",
        "homeString2" => "出售中的房源",
        "homeString3" => "更多热卖房源",
        "homeString4" => "<strong style=\"color: red\">已售出</strong>的房源",
        "homeString5" => "查看全部已售房源",
        "homeString6" => "我们的 <strong>地产经纪</strong>",
        "homeString7" => "专业的地产经纪团队",
        "homeString8" => "<strong>联系</strong> 我们",
        "homeString9" => "欢迎联系我们。。。",
        "homeString10" => "给我们留言",
        "homeString11" => "全名..",
        "homeString12" => "邮箱..",
        "homeString13" => "电话..",
        "homeString14" => "网站..",
        "homeString15" => "<span>联系</span> 信息",
        "homeString16" => "在这里留言..",
        "homeString17" => "查看",
        "homeString18" => "主页",

        "homesTitle" => "最新房源",
        "homesDescription" => "最新的房源信息，第一时间发布最新房源。",
        "homesKeywords" => "最新房源",
        "homesString1" => "最新房源",
        "homesString2" => "主页",
        "homesString3" => "最新房源",
        "homesString4" => "街道名称",
        "homesString5" => "卧室",
        "homesString6" => "任意",
        "homesString7" => "卫生间",
        "homesString8" => "任意",
        "homesString9" => "价格区间",
        "homesString10" => "搜索",
        "homesString11" => "联系我们的地产经纪",
        "homesString12" => "您的姓名..",
        "homesString13" => "(选填)",
        "homesString14" => "您的邮箱..",
        "homesString15" => "您的姓名",
        "homesString16" => "电话",
        "homesString17" => "邮箱",
        "homesString18" => "留言内容",
        "homesString19" => "在这里留言..",
        "homesString20" => "温馨之家一搜即来",
        "homesString21" => "提交信息",

        "homesViewString1" => "共找到 ",
        "homesViewString2" => "个房源",
        "homesViewString3" => "默认列表",
        "homesViewString4" => "全部在售房源",
        "homesViewString5" => "全部已售房源",
        "homesViewString6" => "特价中的房源",
        "homesViewString7" => "排序：价格从低到高",
        "homesViewString8" => "排序：价格从高到低",


        "homeDetailString1" => "房源详情",
        "homeDetailString2" => "概况",
        "homeDetailString3" => "关键信息",
        "homeDetailString4" => "平方米地产 ID: ",
        "homeDetailString5" => "建造年份: ",
        "homeDetailString6" => "每平方英尺:",
        "homeDetailString7" => "状态: ",
        "homeDetailString8" => "系统信息",
        "homeDetailString9" => "图集",
        "homeDetailString10" => "查看",
        "homeDetailString11" => "加载更多",
        "homeDetailString12" => "房屋概况",
        "homeDetailString13" => "卧室",
        "homeDetailString14" => "卫生间",
        "homeDetailString15" => "地下室",
        "homeDetailString16" => "车库和停车位",
        "homeDetailString17" => "完成度",
        "homeDetailString18" => "升级",
        "homeDetailString19" => "位置",
        "homeDetailString20" => "猜你喜欢",
        "homeDetailString21" => "发布日期: ",
        "homeDetailString22" => "欢迎联系我们的地产经纪，",
        "homeDetailString23" => "联系方式",
        "homeDetailString24" => "给我留言",
        "homeDetailString25" => "关于我",
        "homeDetailString26" => "您的姓名",
        "homeDetailString27" => "电话",
        "homeDetailString28" => "邮箱",
        "homeDetailString29" => "留言",
        "homeDetailString30" => "在此留言..",
        "homeDetailString31" => "您的姓名..",
        "homeDetailString32" => "(选填)",
        "homeDetailString33" => "您的邮箱..",
        "homeDetailString34" => "姓名",
        "homeDetailString35" => "电话",
        "homeDetailString36" => "邮箱",
        "homeDetailString37" => "进入我的主页",
        "homeDetailString38" => "发送留言",




        "agentTeamTitle" => "地产经纪团队",
        "agentTeamDescription" => "平方米专业地产经纪团队",
        "agentTeamKeywords" => "地产经纪",
        "agentTeamString1" => "我们的地产经纪团队",
        "agentTeamString2" => "主页",
        "agentTeamString3" => "经纪团队",
        "agentTeamString4" => "我们的团队",
        "agentTeamString5" => "平方米地产经纪",
        "agentTeamString6" => "",
        "agentTeamString7" => "",
        "agentTeamString8" => "",

        "newsUTitle" => "地产新闻",
        "newsDescription" => "温尼伯地产新闻中心",
        "newsKeywords" => "地产新闻",
        "newsString1" => "地产新闻",
        "newsString2" => "主页",
        "newsString3" => "地产新闻",
        "newsString4" => "阅读全文",
        "newsString5" => "在此搜索..",
        "newsString6" => "文章分类",
        "newsString7" => "最近发布",
        "newsString8" => "文章分档",


        "contactUsTitle" => "关于我们",
        "contactUsDescription" => "平方米地产- Square Meter Realty经纪公司 ，是一家提供温尼伯房地产销售，地产咨询，新经纪培训的地产经纪公司，由温尼伯资深房地产经纪人卜涧松创立。",
        "contactUsKeywords" => "平方米地产,经纪公司,温尼伯",
        "contactUsString1" => "关于我们",
        "contactUsString2" => "主页",
        "contactUsString3" => "关于我们",
        "contactUsString4" => "关于我们",
        "contactUsString5" => "温尼伯第一个华人地产经纪公司",
        "contactUsString6" => "<p>平方米地产- Square Meter Realty经纪公司 ，是一家提供温尼伯房地产销售，地产咨询，新经纪培训的地产经纪公司，由温尼伯资深房地产经纪人卜涧松创立。作为温尼伯唯一华人地产经纪公司，多数开心满意的客户是我们多年来收货的最宝贵财富。 我们追求的是团队精神，注重培训经纪的专业知识， 把专业，努力，负责任作为公司的服务宗旨，同时让更多的人理解我们的商业文化和规划。我们长期致力于招纳并培训出色的全方位地产经纪人。</p><p>我们的追求
关注我们您将得到温尼伯最新最全的买房，卖房，投资，房屋养护知识。我们的专业团队将为你提供专业的服务。</p><p><strong>如有任何房屋买卖，房屋养护的问题都可以向我们咨询，我们会一一为你做出解答。我们期待着您的留言和来电！</strong></p>",
        "contactUsString7" => "品质追求",
        "contactUsString8" => "品质，我们永恒的追求",
        "contactUsString9" => "<p>公司由创立至今，吸引了多位优秀的房产经纪人和公司并肩作战。我们为每一位顾客争取最佳利益，以我们丰富的经验，专业的知识服务于每一位新老顾客。为他们提供省时，省力，省钱的全方位综合服务，并且确保我们每一位客户享受到无忧的房地产服务。</p><p>
我们的服务买房：我们团队会是最好的聆听者，会耐心的了解您的购房需求，并根据您的要求为你做出全面的利弊分析，选中最适合您的房源。我们训练有素的团队会利用丰富的经验和专业的知识陪你看房，淘汰掉质量或位置有问题的房源，减小您的购房风险。最后根据我们优秀的谈判技巧帮助您买到称心如意的住房。
卖房：
作为温尼伯唯一华人broker, 卜涧松的团队代理拥有最专业的销售地产经验。我们的10人精英团队将通过多种渠道和大面积广告推广以最快的速度销售出你的房屋。同时我们拥有优质的服务态度，积极的沟通能力，非常好的口碑，以及大量的成功经验。</p><p><strong>以最用心的服务为您寻找最温馨的家</strong></p>",
        "contactUsString10" => "关于我们",
        "contactUsString11" => "品质追求",
        "contactUsString12" => "最新房源信息、地产资讯、一手掌握",
        "contactUsString13" => "扫一扫",
        "contactUsString14" => "地址",
        "contactUsString15" => "邮箱",
        "contactUsString16" => "电话",
        "contactUsString17" => "您的名字..",
        "contactUsString18" => "您的邮箱..",
        "contactUsString19" => "主题..",
        "contactUsString20" => "在这里留言..",
        "contactUsString21" => "提交",
        "contactUsString22" => "关注我们的微信公众号 ",
        "contactUsString23" => "联系我们",
        "contactUsString24" => "您可以在这里找到我们",

        "agentHomeString1" => "平方米经纪",
        "agentHomeString2" => "地产经纪",
        "agentHomeString3" => "关于我",
        "agentHomeString4" => "我的房源",
        "agentHomeString5" => "您可以在这里找到我们",


    );

    echo "<form method=\"post\">";
    foreach ($langArray as $key => $value) {
        echo "  字符值：<input type='text' value='$key' disabled> 内容：<textarea name=\"$key\">$value</textarea> <br>";
    }

    echo "<input type=\"submit\" value='提交保存修改'>
</form>";

}



