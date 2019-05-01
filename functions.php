<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
define('INKER_VERSION', '2');
require_once("libs/themeOptions.php");
require_once("libs/themeOptionsFunction.php");

function getSiteTitle(){
	$db = Typecho_Db::get();
	$query= $db->select('value')->from('table.options')->where('name = ?', 'title'); 
	$row = $db->fetchRow($query);
	return $row["value"];
}

function getSiteUrl(){
	$db = Typecho_Db::get();
	$query= $db->select('value')->from('table.options')->where('name = ?', 'siteUrl'); 
	$row = $db->fetchRow($query);
	return $row["value"];
}

function getThemeName(){
	$db = Typecho_Db::get();
	$query= $db->select('value')->from('table.options')->where('name = ?', 'theme'); 
	$row = $db->fetchRow($query);
	return $row["value"];
}

if(!function_exists('array_column')){
  function array_column($input, $columnKey, $indexKey = NULL){
    $columnKeyIsNumber = (is_numeric($columnKey)) ? TRUE : FALSE;
    $indexKeyIsNull = (is_null($indexKey)) ? TRUE : FALSE;
    $indexKeyIsNumber = (is_numeric($indexKey)) ? TRUE : FALSE;
    $result = array();
    foreach ((array)$input AS $key => $row){ 
      if ($columnKeyIsNumber){
        $tmp = array_slice($row, $columnKey, 1);
        $tmp = (is_array($tmp) && !empty($tmp)) ? current($tmp) : NULL;
      }else{
        $tmp = isset($row[$columnKey]) ? $row[$columnKey] : NULL;
      }
      if ( ! $indexKeyIsNull){
        if ($indexKeyIsNumber){
          $key = array_slice($row, $indexKey, 1);
          $key = (is_array($key) && ! empty($key)) ? current($key) : NULL;
          $key = is_null($key) ? 0 : $key;
        }else{
          $key = isset($row[$indexKey]) ? $row[$indexKey] : 0;
        }
      }
      $result[$key] = $tmp;
    }
    return $result;
  }
}

function findQQUserInfo($access_token,$oauth_consumer_key,$openid){
	$data=array(
		"access_token"=>$access_token,
		"oauth_consumer_key"=>$oauth_consumer_key,
		"openid"=>$openid
	);
	$url = 'https://graph.qq.com/user/get_user_info';
	$client = Typecho_Http_Client::get();
	if ($client) {
		$str = "";
		foreach ( $data as $key => $value ) { 
			$str.= "$key=" . urlencode( $value ). "&" ;
		}
		$data = substr($str,0,-1);
		$client->setData($data)
			->setTimeout(30)
			->send($url);
		$status = $client->getResponseStatus();
		$rs = $client->getResponseBody();
		$arr=json_decode($rs,true);
		return $arr;
	}
	return 0;
}
function findQQOpenID($access_token){
	$data=array(
		"access_token"=>$access_token
	);
	$url = 'https://graph.qq.com/oauth2.0/me';
	$client = Typecho_Http_Client::get();
	if ($client) {
		$str = "";
		foreach ( $data as $key => $value ) { 
			$str.= "$key=" . urlencode( $value ). "&" ;
		}
		$data = substr($str,0,-1);
		$client->setData($data)
			->setTimeout(30)
			->send($url);
		$status = $client->getResponseStatus();
		$rs = $client->getResponseBody();
		if(strpos($rs, "callback") !== false){
			$lpos = strpos($rs, "(");
			$rpos = strrpos($rs, ")");
			$rs = substr($rs, $lpos + 1, $rpos - $lpos -1);
		}
		$user = json_decode($rs);
		if(!isset($user->error)){
			return $user;
		}
	}
	return 0;
}
function findQQAccessToken($qq_appid,$qq_appkey,$qq_callback,$code){
	$data=array(
		"grant_type"=>'authorization_code',
		"client_id"=>$qq_appid,
		"client_secret"=>$qq_appkey,
		"code"=>$code,
		"redirect_uri"=>$qq_callback
	);
	$url = 'https://graph.qq.com/oauth2.0/token';
	$client = Typecho_Http_Client::get();
	if ($client) {
		$str = "";
		foreach ( $data as $key => $value ) { 
			$str.= "$key=" . urlencode( $value ). "&" ;
		}
		$data = substr($str,0,-1);
		$client->setData($data)
			->setTimeout(30)
			->send($url);
		$status = $client->getResponseStatus();
		$rs = $client->getResponseBody();
		parse_str($rs,$arr);
		return $arr;
	}
	return 0;
}

/*输出友情链接*/
function printFriends($link){
	?>
	<style>
	.friendlink{margin:0 auto;width:calc(100% - 100px);}
	@media screen and (max-width:calc(100% - 100px);) {
		.friendlink{width: calc(100% - 100px);}
	}
	</style>
	<?php
	$friendlink=json_decode($link,true);
	if(isset($friendlink)){
		$friendlinks='<div class="friendlink"><marquee direction="up" behavior="scroll" scrollamount="1" scrolldelay="10" loop="-1" onMouseOver="this.stop()" onMouseOut="this.start()" width="100%" height="30" style="text-align:center;">友情链接：';
		array_multisort(array_column($friendlink, 'order'), SORT_DESC, $friendlink);
		$isHaveLink=false;
		foreach($friendlink as $value){
			if($value["name"]!=null&&$value["link"]!=null&&$value["type"]=="home"){
				$isHaveLink=true;
				$icon=$value["icon"]!=""?$value["icon"]:"0";
				$iconlink=is_numeric($icon)?'https://wpa.qq.com/msgrd?v=3&uin='.$icon.'&site=qq&menu=yes':$value["link"];
				$iconimg=is_numeric($icon)?'https://q1.qlogo.cn/g?b=qq&nk='.$icon.'&s=100':$icon;
				$friendlinks.='<a href=javascript:open("'.$iconlink.'");><img src="'.$iconimg.'" width="16" /></a><a href="'.$value["link"].'" target="'.$value["target"].'" title="'.$value["detail"].'" rel="'.$value["rel"].'">'.$value["name"].'</a>&nbsp;';
			}
		}
		$friendlinks.='</marquee></div>';
		if(!$isHaveLink){
			$friendlinks='';
		}
		echo $friendlinks;
	}
}

/*文章阅读次数统计*/
function get_post_view($archive) {
    $cid = $archive->cid;
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
        echo 0;
        return;
    }
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    if ($archive->is('single')) {
        $views = Typecho_Cookie::get('extend_contents_views');
        if (empty($views)) {
            $views = array();
        } else {
            $views = explode(',', $views);
        }
        if (!in_array($cid, $views)) {
            $db->query($db->update('table.contents')->rows(array('views' => (int)$row['views'] + 1))->where('cid = ?', $cid));
            array_push($views, $cid);
            $views = implode(',', $views);
            Typecho_Cookie::set('extend_contents_views', $views); //记录查看cookie
        }
    }
    echo $row['views'];
}

/*调用热门文章*/
function getHotCommentsArticle($limit = 10){
    $db = Typecho_Db::get();
	$result = $db->fetchAll($db->select()->from('table.contents')
        ->where('status = ?','publish')
        ->where('type = ?', 'post')
        ->where('table.contents.created <= unix_timestamp(now())', 'post')
        ->limit($limit)
        ->order('commentsNum', Typecho_Db::SORT_DESC)
    );
	return $result;
}

/**
 * 获取gravatar头像地址 
 * 
 * @param string $mail 
 * @param int $size 
 * @param string $rating 
 * @param string $default 
 * @param bool $isSecure 
 * @return string
 */
function gravatarUrl($mail, $size, $rating, $default, $isSecure = false)
{
		$reg = "/^\d{5,11}@[qQ][Qq]\.(com)$/";
		if (preg_match($reg, $mail)) {
			$img    = explode("@", $mail);
			$url = "//q2.qlogo.cn/headimg_dl?dst_uin={$img[0]}&spec=240";
		} else {
			if (defined('__TYPECHO_GRAVATAR_PREFIX__')) {
				$url = __TYPECHO_GRAVATAR_PREFIX__;
			} else {
				$url = $isSecure ? 'https://secure.gravatar.com' : 'http://www.gravatar.com';
				$url .= '/avatar/';
			}
			if (!empty($mail)) {
				$url .= md5(strtolower(trim($mail)));
			}
			$url .= '?s=' . $size;
			$url .= '&amp;r=' . $rating;
			$url .= '&amp;d=' . $default;
		}
		return $url;
}

//获取文章附件图
function getPostAttImg($obj) {
	$stack = $obj->attachments()->stack;
	$atts = array();
	for($i = 0; $i < count($stack); $i++) {
		$att = $stack[$i]['attachment'];
		if($att->isImage) {
			$atts[] = array('name' => $att->name, 'url' => $att->url);
        }
	}
	return $atts;
}

//获取文章内容图
function getPostHtmImg($obj) {
	preg_match_all( "/<[img|IMG].*?src=[\'|\"](.*?)[\'|\"].*?[\/]?>/", $obj->content, $matches);
	$atts = array();
	if(isset($matches[1][0])) {
		for($i = 0; $i < count($matches[1]); $i++) {
			$atts[] = array('name' => $obj->title.' ['.($i + 1).']', 'url' => $matches[1][$i]);
		}
    }
	return  count($atts) ? $atts : NULL;
}

//获取文章图片 整合 getPostAttImg() 与 getPostHtmImg()
function getPostImg($obj) {
	$imgs = array();
	if($obj->fields->src == 0) {
		$imgs = getPostAttImg($obj);
	}elseif($obj->fields->src == 1) {
		$imgs = getPostHtmImg($obj);
	}elseif($obj->fields->src == 2) {
		$imgs = array_merge(getPostHtmImg($obj), getPostAttImg($obj));
	}
	return $imgs;
}

/**
 * 解析 user-agent 返回对应的操作系统和浏览器信息
 * @param $ua user-agent
 *
 * @return string html 标签
 */
function parseUseragent($ua){

    // 解析操作系统
    $htmlTag = "";
    $os = null;
    $fontClass = null;
    if (preg_match('/Windows NT 6.0/i', $ua)) {$os = "Windows Vista";
        $fontClass = "windows";} elseif (preg_match('/Windows NT 6.1/i', $ua)) {$os = "Windows 7";
        $fontClass = "windows";} elseif (preg_match('/Windows NT 6.2/i', $ua)) {$os = "Windows 8";
        $fontClass = "windows";} elseif (preg_match('/Windows NT 6.3/i', $ua)) {$os = "Windows 8.1";
        $fontClass = "windows";} elseif (preg_match('/Windows NT 10.0/i', $ua)) {$os = "Windows 10";
        $fontClass = "windows";} elseif (preg_match('/Windows NT 5.1/i', $ua)) {$os = "Windows XP";
        $fontClass = "windows";} elseif (preg_match('/Windows NT 5.2/i', $ua) && preg_match('/Win64/i', $ua)) {$os = "Windows XP 64 bit";
        $fontClass = "windows";} elseif (preg_match('/Android ([0-9.]+)/i', $ua, $matches)) {$os = "Android " . $matches[1];
        $fontClass = "android";} elseif (preg_match('/iPhone OS ([_0-9]+)/i', $ua, $matches)) {$os = 'iPhone ' . $matches[1];
        $fontClass = "iphone";} elseif (preg_match('/iPad/i', $ua)) {$os = "iPad";
        $fontClass = "ipad";} elseif (preg_match('/Mac OS X ([_0-9]+)/i', $ua, $matches)) {$os = 'Mac OS X ' . $matches[1];
        $fontClass = "mac";} elseif (preg_match('/Gentoo/i', $ua)) {$os = 'Gentoo Linux';
        $fontClass = "gentoo";} elseif (preg_match('/Ubuntu/i', $ua)) {$os = 'Ubuntu Linux';
        $fontClass = "ubuntu";} elseif (preg_match('/Debian/i', $ua)) {$os = 'Debian Linux';
        $fontClass = "debian";} elseif (preg_match('/X11; FreeBSD/i', $ua)) {$os = 'FreeBSD';
        $fontClass = "freebsd";} elseif (preg_match('/X11; Linux/i', $ua)) {$os = 'Linux';
        $fontClass = "linux";} else { $os = 'unknown os';
        $fontClass = "os";}

    $htmlTag = "<i class=\"iconfont icon-aria-$fontClass\"></i>";

    $browser = null;
    //解析浏览器
    if (preg_match('#SE 2([a-zA-Z0-9.]+)#i', $ua, $matches)) {$browser = 'Sogou browser';
        $fontClass = "sogou";} elseif (preg_match('#360([a-zA-Z0-9.]+)#i', $ua, $matches)) {$browser = '360 browser ';
        $fontClass = "360";} elseif (preg_match('#Maxthon( |\/)([a-zA-Z0-9.]+)#i', $ua, $matches)) {$browser = 'Maxthon ';
        $fontClass = "maxthon";} elseif (preg_match('#Edge( |\/)([a-zA-Z0-9.]+)#i', $ua, $matches)) {$browser = 'Edge ';
        $fontClass = "edge";} elseif (preg_match('#MicroMessenger/([a-zA-Z0-9.]+)#i', $ua, $matches)) {$browser = 'Wechat ';
        $fontClass = "wechat";} elseif (preg_match('#QQ/([a-zA-Z0-9.]+)#i', $ua, $matches)) {$browser = 'QQ Mobile ';
        $fontClass = "qq";} elseif (preg_match('#Chrome/([a-zA-Z0-9.]+)#i', $ua, $matches)) {$browser = 'Chrome ';
        $fontClass = "chrome";} elseif (preg_match('#CriOS/([a-zA-Z0-9.]+)#i', $ua, $matches)) {$browser = 'Chrome ';
        $fontClass = "chrome";} elseif (preg_match('#Chromium/([a-zA-Z0-9.]+)#i', $ua, $matches)) {$browser = 'Chromium ';
        $fontClass = "chrome";} elseif (preg_match('#Safari/([a-zA-Z0-9.]+)#i', $ua, $matches)) {$browser = 'Safari ';
        $fontClass = "safari";} elseif (preg_match('#opera mini#i', $ua)) {
        preg_match('#Opera/([a-zA-Z0-9.]+)#i', $ua, $matches);
        $browser = 'Opera Mini ';
        $fontClass = "opera";
    } elseif (preg_match('#Opera.([a-zA-Z0-9.]+)#i', $ua, $matches)) {$browser = 'Opera ';
        $fontClass = "opera";} elseif (preg_match('#QQBrowser ([a-zA-Z0-9.]+)#i', $ua, $matches)) {$browser = 'QQ browser ';
        $fontClass = "qqbrowser";} elseif (preg_match('#UCWEB([a-zA-Z0-9.]+)#i', $ua, $matches)) {$browser = 'UCWEB ';
        $fontClass = "uc";} elseif (preg_match('#MSIE ([a-zA-Z0-9.]+)#i', $ua, $matches)) {$browser = 'Internet Explorer ';
        $fontClass = "ie";} elseif (preg_match('#Trident/([a-zA-Z0-9.]+)#i', $ua, $matches)) {$browser = 'Internet Explorer 11';
        $fontClass = "ie";} elseif (preg_match('#(Firefox|Phoenix|Firebird|BonEcho|GranParadiso|Minefield|Iceweasel)/([a-zA-Z0-9.]+)#i', $ua, $matches)) {$browser = 'Firefox ';
        $fontClass = "firefox";} else { $browser = 'unknown br';
        $fontClass = 'browser';}

    $htmlTag .= "&nbsp;";
    $htmlTag .= "<i class=\"iconfont icon-aria-$fontClass\"></i>";
    return $htmlTag;
}

/**
 * 输出评论回复内容，配合 commentAtContent($coid)一起使用
 */
function showCommentContent($coid){
    $db = Typecho_Db::get();
    $result = $db->fetchRow($db->select('text')->from('table.comments')->where('coid = ? AND status = ?', $coid, 'approved'));
    $text = @$result['text'];
	if(isset($text)){
		$atStr = commentAtContent($coid);
		$_content = Markdown::convert($text);
		if ($atStr !== '') {
			$content = substr_replace($_content, $atStr, 0, 3);
		} else {
			$content = $_content;
		}
	}else{
		$content = "该评论正在审核中……";
	}
    echo $content;
}

/**
 * 评论回复加@
 */
function commentAtContent($coid){
    $db = Typecho_Db::get();
    $prow = $db->fetchRow($db->select('parent')->from('table.comments')->where('coid = ? AND status = ?', $coid, 'approved'));
    $parent = @$prow['parent'];
    if ($parent != "0") {
        $arow = $db->fetchRow($db->select('author')->from('table.comments')
                ->where('coid = ? AND status = ?', $parent, 'approved'));
        $author = @$arow['author'];
        $href = '<p><a href="#comment-' . $parent . '">@' . $author . '</a><br>';
        return $href;
    } else {
        return '';
    }
}

/**
 * 输出评论回复/取消回复按钮
 */
function commentReply($archive){
    echo "<script type=\"text/javascript\">
    window.TypechoComment = {
        dom : function (id) {
            return document.getElementById(id);
        },

        create : function (tag, attr) {
            var el = document.createElement(tag);

            for (var key in attr) {
                el.setAttribute(key, attr[key]);
            }

            return el;
        },

        reply : function (cid, coid) {
            var comment = this.dom(cid), parent = comment.parentNode,
                response = this.dom('$archive->respondId'), input = this.dom('comment-parent'),
                form = 'form' == response.tagName ? response : response.getElementsByTagName('form')[0],
                textarea = response.getElementsByTagName('textarea')[0];

            if (null == input) {
                input = this.create('input', {
                    'type' : 'hidden',
                    'name' : 'parent',
                    'id'   : 'comment-parent'
                });

                form.appendChild(input);
            }

            input.setAttribute('value', coid);

            if (null == this.dom('comment-form-place-holder')) {
                var holder = this.create('div', {
                    'id' : 'comment-form-place-holder'
                });

                response.parentNode.insertBefore(holder, response);
            }

            comment.appendChild(response);
            this.dom('cancel-comment-reply-link').style.display = '';

            if (null != textarea && 'text' == textarea.name) {
                textarea.focus();
            }
			$('#comment-form input[name=\"text\"]').attr('style','');
            return false;
        },

        cancelReply : function () {
            var response = this.dom('$archive->respondId'),
            holder = this.dom('comment-form-place-holder'), input = this.dom('comment-parent');

            if (null != input) {
                input.parentNode.removeChild(input);
            }

            if (null == holder) {
                return true;
            }

            this.dom('cancel-comment-reply-link').style.display = 'none';
            holder.parentNode.insertBefore(response, holder);
			$('#comment-form input[name=\"text\"]').attr('style','position: absolute;left: 0;bottom: 0;');
            return false;
        }
    }
</script>
";
}