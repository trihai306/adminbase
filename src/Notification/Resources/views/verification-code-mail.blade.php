<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta
        name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Xác minh Email</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Niramit:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    />
    <style>
        html,
        body {
            margin: 0;
            font-family: 'Niramit', sans-serif;
        }

        .mt-3 {
            margin-top: 1rem;
        }

        .mt-4 {
            margin-top: 1.5rem;
        }

        .text-center {
            text-align: center;
        }

        .wrap {
            width: 550px;
            max-width: 100%;
            margin: auto;
            color: #3a3e64;
            font-weight: 400;
            font-size: 14px;
            line-height: calc(20 / 14);
        }

        .header {
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #13112e;
        }

        .logo {
            display: block;
            width: 90px;
            height: 20px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .content {
            padding: 48px 32px;
        }

        .heading {
            font-weight: 600;
            font-size: 20px;
            color: #13112e;
            line-height: calc(28 / 20);
        }

        .verification-btn {
            background: linear-gradient(90deg, #4c5ffd -0.03%, #1841d3 100.03%);
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 600;
            color: #f8f8f8;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .link {
            color: #5081ff;
            text-decoration: none;
        }

        .socials {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .social-icon {
            width: 32px;
            height: 32px;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .footer {
            font-size: 12px;
            font-weight: 600;
            line-height: calc(17 / 12);
            color: #13112e;
            text-align: center;
        }

        .copyright {
            margin-top: 12px;
            font-weight: 600;
        }
    </style>
</head>
<body>
<div class="wrap">
    <div class="header">
        <div class="logo">
            <img
                src="data:image/png;base64,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"
                alt="Muakey.com"
            />
        </div>
    </div>
    <div class="content">
        <div class="heading">Xác minh Email</div>
        <div class="mt-3">
            Để hoàn thành Đăng ký tài khoản và bắt đầu mua hàng, vui lòng xác minh
            email bằng cách bấm vào link dưới đây:
        </div>
        <div class="text-center">
            <a href="{{ $domain }}/register?email={{ $email }}&code={{ $code }}" class="verification-btn mt-4">Xác minh email</a>
        </div>
        <div class="mt-4">
            Nếu nút bên trên không hoạt động, vui lòng sử dụng liên kết bên dưới:
            <a
                class="link"
                href="{{ $domain }}/register?email={{ $email }}&code={{ $code }}"
            >
                {{ $domain }}/register?email={{ $email }}&code={{ $code }}
            </a>
        </div>
        <div class="mt-4">Cám ơn bạn!</div>
    </div>
    <div class="footer">
        <div class="socials">
            <div class="social-icon">
                <svg
                    width="32"
                    height="33"
                    viewBox="0 0 32 33"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <rect
                        y="0.927368"
                        width="32"
                        height="32"
                        rx="10"
                        fill="#E8E8E8"
                    />
                    <path
                        d="M24.5 16.9794C24.5 12.2561 20.6946 8.42737 16.0011 8.42737C11.3054 8.42843 7.5 12.2561 7.5 16.9805C7.5 21.248 10.6085 24.7857 14.671 25.4274V19.4516H12.5144V16.9805H14.6731V15.0948C14.6731 12.952 15.9426 11.7685 17.8836 11.7685C18.8142 11.7685 19.7863 11.9353 19.7863 11.9353V14.0388H18.7143C17.6594 14.0388 17.3301 14.6985 17.3301 15.3753V16.9794H19.6864L19.3103 19.4505H17.329V25.4263C21.3915 24.7846 24.5 21.247 24.5 16.9794Z"
                        fill="#4B4B4B"
                    />
                </svg>
            </div>
            <div class="social-icon">
                <svg
                    width="32"
                    height="33"
                    viewBox="0 0 32 33"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <rect
                        y="0.927368"
                        width="32"
                        height="32"
                        rx="10"
                        fill="#E8E8E8"
                    />
                    <path
                        d="M24.6243 12.5901C24.5219 12.2085 24.321 11.8604 24.0417 11.5809C23.7625 11.3013 23.4147 11.1 23.0333 10.997C21.629 10.6193 16 10.6193 16 10.6193C16 10.6193 10.371 10.6193 8.96674 10.995C8.58509 11.0976 8.23715 11.2988 7.95787 11.5785C7.67859 11.8581 7.4778 12.2063 7.37567 12.5881C7 13.9943 7 16.9274 7 16.9274C7 16.9274 7 19.8604 7.37567 21.2646C7.58259 22.0401 8.1933 22.6508 8.96674 22.8577C10.371 23.2354 16 23.2354 16 23.2354C16 23.2354 21.629 23.2354 23.0333 22.8577C23.8087 22.6508 24.4174 22.0401 24.6243 21.2646C25 19.8604 25 16.9274 25 16.9274C25 16.9274 25 13.9943 24.6243 12.5901ZM14.2121 19.6193V14.2354L18.8728 16.9073L14.2121 19.6193Z"
                        fill="#4B4B4B"
                    />
                </svg>
            </div>
            <div class="social-icon">
                <svg
                    width="32"
                    height="33"
                    viewBox="0 0 32 33"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <rect
                        y="0.927368"
                        width="32"
                        height="32"
                        rx="10"
                        fill="#E8E8E8"
                    />
                    <path
                        d="M23.5 15.3089C22.0255 15.3126 20.5872 14.8298 19.3882 13.9287V20.2134C19.3878 21.3774 19.0489 22.5135 18.417 23.4698C17.785 24.4262 16.89 25.1571 15.8517 25.565C14.8133 25.9728 13.6812 26.0381 12.6065 25.7522C11.5319 25.4662 10.566 24.8425 9.83809 23.9646C9.11015 23.0867 8.65481 21.9964 8.53298 20.8395C8.41115 19.6825 8.62862 18.5141 9.15632 17.4904C9.68402 16.4667 10.4968 15.6366 11.486 15.111C12.4751 14.5855 13.5935 14.3895 14.6916 14.5493V17.7103C14.1891 17.5444 13.6496 17.5494 13.1499 17.7246C12.6503 17.8998 12.2162 18.2364 11.9096 18.6861C11.603 19.1358 11.4395 19.6758 11.4426 20.2289C11.4457 20.782 11.6152 21.3199 11.9268 21.7658C12.2385 22.2117 12.6763 22.5428 13.1779 22.7119C13.6795 22.8809 14.2191 22.8793 14.7197 22.7071C15.2203 22.5349 15.6563 22.2011 15.9654 21.7533C16.2745 21.3054 16.4409 20.7665 16.4409 20.2134V7.92737H19.3882C19.3862 8.18869 19.407 8.44966 19.4505 8.70698C19.5529 9.2814 19.7659 9.82784 20.0763 10.3129C20.3868 10.7979 20.7882 11.2114 21.256 11.5279C21.9217 11.99 22.702 12.2363 23.5 12.2362V15.3089Z"
                        fill="#4B4B4B"
                    />
                </svg>
            </div>
            <div class="social-icon">
                <svg
                    width="32"
                    height="33"
                    viewBox="0 0 32 33"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <rect
                        y="0.927368"
                        width="32"
                        height="32"
                        rx="10"
                        fill="#E8E8E8"
                    />
                    <path
                        d="M15.998 14.2596C14.529 14.2596 13.3302 15.4584 13.3302 16.9274C13.3302 18.3964 14.529 19.5952 15.998 19.5952C17.467 19.5952 18.6658 18.3964 18.6658 16.9274C18.6658 15.4584 17.467 14.2596 15.998 14.2596ZM23.9994 16.9274C23.9994 15.8226 24.0094 14.7279 23.9474 13.6251C23.8853 12.3443 23.5931 11.2075 22.6565 10.2709C21.7179 9.33224 20.5831 9.04204 19.3022 8.98C18.1975 8.91796 17.1027 8.92796 16 8.92796C14.8953 8.92796 13.8005 8.91796 12.6978 8.98C11.4169 9.04204 10.2801 9.33424 9.3435 10.2709C8.40487 11.2095 8.11467 12.3443 8.05263 13.6251C7.99059 14.7299 8.0006 15.8246 8.0006 16.9274C8.0006 18.0301 7.99059 19.1269 8.05263 20.2296C8.11467 21.5105 8.40687 22.6472 9.3435 23.5839C10.2821 24.5225 11.4169 24.8127 12.6978 24.8747C13.8025 24.9368 14.8973 24.9268 16 24.9268C17.1047 24.9268 18.1995 24.9368 19.3022 24.8747C20.5831 24.8127 21.7199 24.5205 22.6565 23.5839C23.5951 22.6452 23.8853 21.5105 23.9474 20.2296C24.0114 19.1269 23.9994 18.0321 23.9994 16.9274ZM15.998 21.0321C13.7265 21.0321 11.8932 19.1989 11.8932 16.9274C11.8932 14.6558 13.7265 12.8226 15.998 12.8226C18.2695 12.8226 20.1028 14.6558 20.1028 16.9274C20.1028 19.1989 18.2695 21.0321 15.998 21.0321ZM20.2709 13.6131C19.7405 13.6131 19.3122 13.1848 19.3122 12.6545C19.3122 12.1241 19.7405 11.6958 20.2709 11.6958C20.8012 11.6958 21.2295 12.1241 21.2295 12.6545C21.2297 12.7804 21.205 12.9051 21.1569 13.0215C21.1088 13.1379 21.0382 13.2436 20.9491 13.3327C20.8601 13.4218 20.7543 13.4924 20.6379 13.5405C20.5216 13.5886 20.3968 13.6133 20.2709 13.6131Z"
                        fill="#4B4B4B"
                    />
                </svg>
            </div>
            <div class="social-icon">
                <svg
                    width="32"
                    height="33"
                    viewBox="0 0 32 33"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <rect
                        y="0.927368"
                        width="32"
                        height="32"
                        rx="10"
                        fill="#E8E8E8"
                    />
                    <path
                        d="M25 11.0432C24.3381 11.3524 23.627 11.5614 22.8794 11.6559C23.6508 11.1692 24.2278 10.4033 24.503 9.50104C23.7783 9.9549 22.9851 10.2744 22.158 10.4456C21.6018 9.81939 20.8651 9.40435 20.0623 9.26489C19.2594 9.12543 18.4354 9.26933 17.7181 9.67427C17.0007 10.0792 16.4303 10.7225 16.0953 11.5043C15.7602 12.2861 15.6794 13.1627 15.8652 13.9979C14.3968 13.9202 12.9603 13.5178 11.649 12.8168C10.3376 12.1158 9.18071 11.1319 8.25332 9.929C7.93623 10.5057 7.7539 11.1744 7.7539 11.8866C7.75354 12.5277 7.90328 13.1589 8.18981 13.7244C8.47634 14.2898 8.89082 14.7719 9.39646 15.128C8.81005 15.1083 8.23658 14.9412 7.72377 14.6407V14.6908C7.72371 15.59 8.0187 16.4615 8.55868 17.1574C9.09865 17.8534 9.85036 18.3309 10.6863 18.509C10.1423 18.6642 9.57192 18.6871 9.01832 18.5759C9.25416 19.3495 9.71355 20.0261 10.3322 20.5108C10.9508 20.9955 11.6977 21.2641 12.4683 21.279C11.1602 22.3618 9.54461 22.9491 7.88153 22.9465C7.58693 22.9466 7.29258 22.9285 7 22.8922C8.68813 24.0366 10.6532 24.644 12.6602 24.6416C19.454 24.6416 23.168 18.7088 23.168 13.5633C23.168 13.3961 23.164 13.2273 23.1569 13.0601C23.8793 12.5092 24.5029 11.8271 24.9984 11.0457L25 11.0432Z"
                        fill="#4B4B4B"
                    />
                </svg>
            </div>
            <div class="social-icon">
                <svg
                    width="32"
                    height="33"
                    viewBox="0 0 32 33"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <rect
                        y="0.927368"
                        width="32"
                        height="32"
                        rx="10"
                        fill="#E8E8E8"
                    />
                    <path
                        d="M22.2377 11.4676C21.0902 10.9658 19.8602 10.5949 18.574 10.384C18.5626 10.3819 18.5507 10.3833 18.5401 10.388C18.5295 10.3927 18.5206 10.4004 18.5148 10.4102C18.3573 10.6786 18.1818 11.0284 18.0588 11.3047C16.6947 11.1071 15.3078 11.1071 13.9437 11.3047C13.8067 10.9984 13.6522 10.6998 13.4809 10.4102C13.4751 10.4003 13.4663 10.3924 13.4557 10.3874C13.4452 10.3825 13.4333 10.3808 13.4217 10.3826C12.1362 10.5935 10.9062 10.9644 9.75803 11.4669C9.74815 11.4709 9.73978 11.4777 9.73403 11.4865C7.4001 14.8136 6.76037 18.0584 7.07461 21.2626C7.07548 21.2704 7.07799 21.278 7.08199 21.2849C7.08599 21.2918 7.09139 21.2978 7.09786 21.3026C8.46011 22.2643 9.97953 22.9969 11.5925 23.4697C11.6037 23.4731 11.6157 23.4731 11.627 23.4697C11.6382 23.4663 11.6482 23.4597 11.6555 23.4508C12.0026 23.0007 12.3101 22.5232 12.5749 22.0233C12.5786 22.0164 12.5807 22.0089 12.5812 22.0012C12.5816 21.9935 12.5803 21.9858 12.5774 21.9787C12.5745 21.9715 12.57 21.965 12.5643 21.9597C12.5585 21.9543 12.5517 21.9502 12.5442 21.9476C12.0597 21.7707 11.5903 21.5572 11.1402 21.3091C11.1322 21.3047 11.1253 21.2983 11.1204 21.2907C11.1155 21.283 11.1126 21.2743 11.112 21.2653C11.1114 21.2562 11.1131 21.2472 11.117 21.239C11.1209 21.2308 11.1268 21.2237 11.1342 21.2182C11.2287 21.1506 11.3232 21.0801 11.4132 21.0095C11.4213 21.0032 11.4311 20.9991 11.4414 20.9979C11.4517 20.9966 11.4622 20.9981 11.4717 21.0023C14.4169 22.2851 17.6066 22.2851 20.5172 21.0023C20.5267 20.9979 20.5373 20.9961 20.5478 20.9973C20.5583 20.9984 20.5682 21.0024 20.5765 21.0088C20.6665 21.0801 20.7602 21.1506 20.8555 21.2182C20.863 21.2236 20.869 21.2306 20.873 21.2387C20.877 21.2469 20.8789 21.2559 20.8784 21.2649C20.878 21.2739 20.8752 21.2826 20.8704 21.2904C20.8656 21.2981 20.859 21.3045 20.851 21.3091C20.4025 21.5593 19.936 21.7709 19.4462 21.9469C19.4387 21.9496 19.4319 21.9537 19.4262 21.9592C19.4204 21.9646 19.416 21.9711 19.413 21.9783C19.4101 21.9856 19.4089 21.9933 19.4093 22.0011C19.4097 22.0088 19.4118 22.0164 19.4155 22.0233C19.6855 22.5229 19.9945 22.9985 20.3342 23.4501C20.3413 23.4594 20.3511 23.4663 20.3624 23.4699C20.3737 23.4736 20.3858 23.4738 20.3972 23.4705C22.0129 22.999 23.5348 22.266 24.8986 21.3026C24.9052 21.2981 24.9108 21.2922 24.915 21.2855C24.9191 21.2787 24.9217 21.2712 24.9226 21.2633C25.2976 17.5588 24.2941 14.3401 22.2609 11.488C22.2559 11.4787 22.2477 11.4715 22.2377 11.4676ZM13.0152 19.3115C12.1287 19.3115 11.3975 18.5341 11.3975 17.5807C11.3975 16.6265 12.1145 15.8499 13.0152 15.8499C13.9227 15.8499 14.6471 16.6331 14.6329 17.5807C14.6329 18.5348 13.9159 19.3115 13.0152 19.3115ZM18.9963 19.3115C18.109 19.3115 17.3786 18.5341 17.3786 17.5807C17.3786 16.6265 18.0948 15.8499 18.9963 15.8499C19.9037 15.8499 20.6282 16.6331 20.614 17.5807C20.614 18.5348 19.9045 19.3115 18.9963 19.3115Z"
                        fill="#4B4B4B"
                    />
                </svg>
            </div>
            <div class="social-icon">
                <svg
                    width="32"
                    height="33"
                    viewBox="0 0 32 33"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <rect
                        y="0.927368"
                        width="32"
                        height="32"
                        rx="10"
                        fill="#E8E8E8"
                    />
                    <path
                        d="M19.5793 14.217C19.6978 14.217 19.8164 14.2211 19.9329 14.2271C19.4427 11.6413 16.7524 9.66431 13.5056 9.66431C9.91327 9.66431 7 12.0873 7 15.077C7 16.7064 7.87599 18.1751 9.24824 19.1676C9.30484 19.2076 9.351 19.2605 9.38282 19.3221C9.41464 19.3836 9.43119 19.4519 9.43107 19.5212C9.43107 19.5694 9.42103 19.6136 9.40897 19.6598C9.29847 20.0677 9.12367 20.7207 9.11564 20.7508C9.10157 20.803 9.08148 20.8553 9.08148 20.9095C9.08148 21.0281 9.17792 21.1265 9.29847 21.1265C9.34468 21.1265 9.38286 21.1084 9.42304 21.0863L10.8475 20.2646C10.954 20.2023 11.0685 20.1641 11.1931 20.1641C11.2574 20.1641 11.3217 20.1742 11.384 20.1923C12.049 20.3831 12.7663 20.4896 13.5076 20.4896C13.6282 20.4896 13.7467 20.4876 13.8653 20.4816C13.7226 20.0597 13.6463 19.6156 13.6463 19.1555C13.6463 16.4271 16.3024 14.217 19.5793 14.217ZM15.6755 12.4791C16.1537 12.4791 16.5435 12.8669 16.5435 13.3451C16.5435 13.8233 16.1557 14.211 15.6755 14.211C15.1973 14.211 14.8076 13.8233 14.8076 13.3451C14.8076 12.8669 15.1973 12.4791 15.6755 12.4791ZM11.3378 14.211C10.8596 14.211 10.4698 13.8233 10.4698 13.3451C10.4698 12.8669 10.8576 12.4791 11.3378 12.4791C11.8179 12.4791 12.2057 12.8669 12.2057 13.3451C12.2057 13.8233 11.8159 14.211 11.3378 14.211ZM23.1275 22.5611C24.2707 21.7333 25 20.5117 25 19.1515C25 16.6602 22.5729 14.641 19.5773 14.641C16.5837 14.641 14.1546 16.6602 14.1546 19.1515C14.1546 21.6429 16.5816 23.6621 19.5773 23.6621C20.1961 23.6621 20.7948 23.5737 21.3474 23.4149C21.3996 23.3989 21.4518 23.3908 21.5061 23.3908C21.6106 23.3908 21.705 23.423 21.7934 23.4732L22.9808 24.1563C23.015 24.1764 23.0471 24.1905 23.0853 24.1905C23.1091 24.1907 23.1327 24.1862 23.1548 24.1772C23.1768 24.1682 23.1969 24.155 23.2139 24.1382C23.2306 24.1213 23.2438 24.1012 23.2528 24.0792C23.2618 24.0571 23.2663 24.0335 23.2661 24.0097C23.2661 23.9655 23.248 23.9213 23.238 23.8771C23.2319 23.8529 23.0853 23.3085 22.9929 22.9669C22.9828 22.9287 22.9748 22.8906 22.9748 22.8524C22.9768 22.7338 23.0371 22.6274 23.1275 22.5611ZM17.7731 18.4322C17.3733 18.4322 17.0498 18.1088 17.0498 17.711C17.0498 17.3132 17.3733 16.9897 17.7731 16.9897C18.1729 16.9897 18.4964 17.3132 18.4964 17.711C18.4964 18.1088 18.1709 18.4322 17.7731 18.4322ZM21.3875 18.4322C20.9877 18.4322 20.6642 18.1088 20.6642 17.711C20.6642 17.3132 20.9877 16.9897 21.3875 16.9897C21.7874 16.9897 22.1108 17.3132 22.1108 17.711C22.1099 17.9023 22.0333 18.0855 21.8978 18.2206C21.7623 18.3558 21.5789 18.4318 21.3875 18.4322Z"
                        fill="#4B4B4B"
                    />
                </svg>
            </div>
        </div>
        <div class="mt-4">
            Đối với các yêu cầu hỗ trợ, vui lòng liên hệ với chúng tôi tại
            <a class="link" href="mailto:hotro@muakey.com">hotro@muakey.com</a>
        </div>
        <div class="copyright">
            Copyright © 2021 Muakey. All Rights Reserved.
        </div>
    </div>
</div>
</body>
</html>
