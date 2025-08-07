<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>My Babe Ecommerce - Contact Us</title>
</head>

<body style="font-family: 'nunito sans' , 'helvetica' , 'arial' , sans-serif; background-color: #F5F5F5;">
    <table align="center" width="600" style="background-color: #F5F5F5;padding: 40px 70px;color: #454648;">
        <tr>
            <td align="center">
                <img src="https://mybabe.devtechnosys.tech/public/storage/assets/website/images/logo.png" alt="Company Logo" style="max-width: 180px;">
            </td>
        </tr>
        <tr>
            <td>
                <div style="background-color: #fff;padding: 40px;border-radius: 16px;margin: 30px 0;">
                    <div style="margin-bottom: 40px;">
                        <h1 style="font-size: 24px;margin: 0px;line-height: 24px;margin-bottom: 10px;">Contact Us
                            Request</h1>
                        <p style="font-size: 16px;color: #585858;line-height: 24px;margin: 0;">You have received a new
                            contact request. Details are as follows:</p>
                    </div>
                    <div>
                        <div style="margin-bottom: 25px;">
                            <h4 style="font-size: 16px;font-weight: 600;margin: 0;margin-bottom: 8px;">Name</h4>
                            <p style="font-size: 16px;color: #585858;line-height: 24px;margin: 0;">{{$contactData["name"]}}</p>
                        </div>
                        <div style="margin-bottom: 25px;">
                            <h4 style="font-size: 16px;font-weight: 600;margin: 0;margin-bottom: 8px;">Subject</h4>
                            <p style="font-size: 16px;color: #585858;line-height: 24px;margin: 0;">{{$contactData["subject"]}}</p>
                        </div>
                        <div style="margin-bottom: 25px;">
                            <h4 style="font-size: 16px;font-weight: 600;margin: 0;margin-bottom: 8px;">Email</h4>
                            <p style="font-size: 16px;color: #585858;line-height: 24px;margin: 0;">{{$contactData["email"]}}</p>
                        </div>
                        <div>
                            <h4 style="font-size: 16px;font-weight: 600;margin: 0;margin-bottom: 8px;">Description</h4>
                            <p style="font-size: 16px;color: #585858;line-height: 24px;margin: 0;">{{$contactData["description"]}}</p>
                        </div>
                        @if($contactData!=null)
                        <div>
                            <h4 style="font-size: 16px;font-weight: 600;margin: 0;margin-bottom: 8px;">Replay</h4>
                            <p style="font-size: 16px;color: #585858;line-height: 24px;margin: 0;">{{$contactData["replay"] ?? ''}}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding-top: 20px;">
                <a href="#" style="margin: 0 10px;"><img src="https://mybabe.devtechnosys.tech/public/storage/assets/website/images/s-icon01.png" alt="Facebook" width="40"></a>
                <a href="#" style="margin: 0 10px;"><img src="https://mybabe.devtechnosys.tech/public/storage/assets/website/images/s-icon02.png" alt="Twitter" width="40"></a>
                <a href="#" style="margin: 0 10px;"><img src="https://mybabe.devtechnosys.tech/public/storage/assets/website/images/s-icon03.png" alt="Instagram" width="40"></a>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding-top: 10px;">
                <p style="font-size: 16px;color: #585858;line-height: 24px;margin: 0;">© 2024 Your Company. All rights reserved. </p>
            </td>
        </tr>
    </table>
</body>
</html>