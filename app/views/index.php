<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="utf-8">
<title>{$title}</title>
<meta name="keywords" content="搜索">
<meta name="description" content="搜索">
<meta name="robots" content="all,follow">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/jquery.cookie.js"></script>
</head>
<body>

    <div><h1>创建成功</h1></div>

    <progress id="Progress" value="0" max="100"></progress>
    <input type="file" name="file" onchange="showPreview(this)" />
    <img id="portrait" src="" width="70" height="75">

<script type="text/javascript">
//获取文件Base64
/**
 * 方法名
 * abort  none    中断读取
 * readAsBinaryString  file    将文件读取为二进制码
 * readAsDataURL  file    将文件读取为 DataURL
 * readAsText  file,[encoding]    将文件读取为文本
 * 事件
 * onabort  中断时触发
 * onerror  出错时触发
 * onload   文件读取成功完成时触发
 * onloadend    读取完成触发，无论成功或失败
 * onloadstart  读取开始时触发
 * onprogress   读取中
 */
function showPreview(source) {
    var file = source.files[0];
    console.log(file);
    if(window.FileReader) {
        var fr = new FileReader();
        fr.onloadend = function(e) {
            console.log(this.result);
            document.getElementById("portrait").src = e.target.result;
        };
        fr.readAsDataURL(file);
    }
    var total = source.files[0].size;
    fr.onprogress = function(ev) {
        console.log(ev.loaded / total);
        var loading = (ev.loaded / total)*100;
        document.getElementById("Progress").value = loading;
    }
}
</script>

</body>
</html>
