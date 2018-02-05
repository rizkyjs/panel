<?php
/*
 * Copyright (c) 2016-2017 Aldiansyah <aldie.ansyah56@gmail.com>,
 * 2006-2017 http://listssh.net *
 * Permission to use, copy, modify, and distribute this software for any
 * purpose with or without fee is hereby granted, provided that the above
 * copyright notice and this permission notice appear in all copies.
 *
 * THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
 * WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR
 * ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
 * WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN
 * ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF
 * OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.
 */


function msg($x,$y){$t=array('status'=>$y,'result'=>$x);echo json_encode($t);}
	
	
/*-------------------------- Admin Area -------------------*/
$root = "passroot"; // password root vps
$usrexp = "7";  //expired user ssh
$yourSite="namawebsite.com-"; // akan menghasilkan userssh namawebsite.com-user

$google="https://www.google.com/recaptcha/api/siteverify?secret=";
$secretKey ="6LcJtCgUAAAAAAdijou_bYlcVpQ3cgpJjXi_wu_V"; //secret key captcha
$u;$p;$s;$c;

if(isset($_POST['username'])){$u=$_POST['username'];}if(isset($_POST['password'])){$p=$_POST['password'];}if(isset($_POST['server'])){$s=$_POST['server'];}if(isset($_POST['g-recaptcha-response'])){$c=$_POST['g-recaptcha-response'];}
if(!$u){exit(msg("Failed User","Failed"));}if(!$p){exit(msg("Failed Password","Failed"));}if(!$s){exit(msg("Overload Server","Failed"));}if(!$c){exit(msg("Ceklis reCAPTCHA","Failed"));}
$r=json_decode(file_get_contents($google.$secretKey."&response=".$c."&remoteip=".$_SERVER['REMOTE_ADDR']),true);if(intval($r["success"])!==1){exit(msg("Reload This Website !","Failed"));}
else{$q=array('cmd'=>'ssh','server'=>$s,'rootpasswd'=>$root,'useradd'=>$yourSite.$u,'userpasswd'=>$p,'userexpired'=>$usrexp);$o=array('http'=>array('header'=>"Content-type: application/x-www-form-urlencoded\r\n",'method'=>'POST','content'=>http_build_query($q)));$d=stream_context_create($o);$t=file_get_contents("http://listssh.us/webapi/",false,$d);if($t===FALSE){}echo $t;exit;}
?>