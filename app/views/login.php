<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Đăng nhập</title>
    <style>
    /* Các kiểu cho mobile */
    @media (max-width: 576px) {
        body {
            background-color: #f8f9fa;
        }

        .container {
            padding: 20px;
        }

        h2 {
            font-size: 1.5rem;
        }

        .btn {
            width: 100%;
            margin-top: 10px;
        }
    }

    /* Các kiểu cho tablet */
    @media (min-width: 577px) and (max-width: 768px) {


        h2 {
            font-size: 2rem;
        }

        .btn {
            width: auto;
        }
    }

    /* Các kiểu cho desktop */
    @media (min-width: 769px) {
        body {
            background-color: #ffffff;
        }

        .container {
            max-width: 400px;
            margin-top: 20px;
            padding: 30px;
        }

        h2 {
            font-size: 2.5rem;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>Đăng nhập</h2>
        <form method="POST" action="index.php?action=login">
            <div class="form-group">
                <label for="username">Tên đăng nhập:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Đăng nhập</button>
        </form>
        <p>Chưa có tài khoản? <a href="index.php?action=register">Đăng ký</a></p>
    </div>
</body>

</html>