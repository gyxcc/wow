<!DOCTYPE html>
<html>
<head>
    <title>foodshare</title>
    <style>
        .button-container {
            text-align: center;
            margin: 20px;
        }

        .role-button {
            display: inline-block;
            background-color: #007BFF;
            color: white;
            padding: 15px 25px;
            margin: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .role-button:hover {
            background-color: #0056b3;
        }

        .role-button img {
            width: 100px; /* Adjust as needed */
            height: auto;
        }

        .role-description {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <header>
        <div style="text-align:right;">
            <a href="login.html">登录</a>
        </div>
        <div style="background-image:url('background.jpg'); text-align:center;">
            <h1>foodshare</h1>
        </div>
    </header>

    <main>
        <section>
            <p style="text-align:center;">您的角色是：</p>
            <!-- 按钮组合 -->
            <div class="button-container">
                <div>
                    <button class="role-button" onclick="location.href='sign_V.php'">
                        <img src="volunteer.jpg" alt="Volunteer">
                        <div class="role-description">捐赠食物</div>
                    </button>
                </div>
                <div>
                    <button class="role-button" onclick="location.href='sign_S.php'">
                        <img src="store.jpg" alt="Store">
                        <div class="role-description">成为合作伙伴</div>
                    </button>
                </div>
                <div>
                    <button class="role-button" onclick="location.href='sign_C.php'">
                        <img src="charity.jpg" alt="Charity">
                        <div class="role-description">加入10元，资助有需要人士一餐饭</div>
                    </button>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
