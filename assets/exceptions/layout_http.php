<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $title ?? ''; ?></title>

<link href='http://fonts.googleapis.com/css?family=Open+Sans:700,300' rel='stylesheet' type='text/css'>

<style type="text/css">
body {
    background-color:#4F3542;
    font-family:'Open Sans',sans-serif;
    margin:0;
    padding:0;
    text-align:center;
    color:#d5ebda;
}

p {
    margin:0;
    margin-bottom:1.5em;
}

.button {
    margin-left:auto;
    margin-right:auto;
}

a.button {
    font-size:1em;
    background-color:#55BF9B;
    padding:.5em 1.5em;
    margin:.5em .2em 0em .2em;
    text-align:center;
    border-radius:.3em;
    text-decoration:none;
    color:#F2ECBA;
}

a.button:hover {
    cursor:pointer;
    background-color:#8BC99A;
    color:#F2ECBA;
}

.clear {
    clear:both;
}

#header {
    background-color:#D5EBDA;
    overflow:hidden;
}

#header #status-code {
    color:#ffffff;
    font-size:300px;
}

#content #title {
    color:#e54560;
    text-align:center;
    font-size:3em;
    margin-top:.5em;
    margin-bottom:.2em;
    padding:0;
}

#content .file {
    font-size: 12px;
    color: #54bf9b;
}

#content #sub-title {
    font-size:15px;
    margin-bottom:45px;
}
</style>
</head>

<body>

    <div>
        <div id="header">
            <div id="status-code">
                <?php echo $statusCode ?? 500; ?>
            </div>
        </div>

        <div id="content">
            <div>
                <p id="title"><?php echo $title ?? ''; ?></p>
                <p id="sub-title"><?php echo $code ?? 0; ?> <?php echo $message ?? ''; ?></p>
                <div class="button">
                    <a class="button" href="/"><?php echo __('首页'); ?></a>
                    <a class="button" href="javascript:;" onclick="window.location.reload();"><?php echo __('重试'); ?></a>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>

</body>
</html>