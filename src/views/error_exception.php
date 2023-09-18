<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="robots" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background-color: #ededed;
            margin: 0;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        .container {
            margin-left: auto;
            margin-right: auto;
            max-width: 768px;
            width: 100%;
            word-break: break-all;
        }

        .short-title {
            background-color: #85271f;
            color: #fff;
            padding: 16px;
        }
        
        .short-title h1, p {
            margin: 0;
        }
        
        .short-title h1 {
            font-size: 49px;
            padding-bottom: 8px;
        }

        .error-description {
            padding: 16px;
            line-height: 1.4rem;
        }
    </style>
</head>
<body>
    <header class="short-title">
        <div class="container">
            <h1><?php echo $title; ?></h1>
            <p><?php echo $message; ?></p>
        </div>
    </header>
    <div class="error-description">
        <div class="container">
            <p><strong><?php echo $message; ?></strong> in <strong><?php echo $file ?></strong> on line 
                <strong><?php echo $line; ?></strong></p>
        </div>
    </div>
</body>
</html>