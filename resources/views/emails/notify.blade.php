<!DOCTYPE html>
<html lang="en">
​
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verify your login</title>
</head>
<body  style="margin-top:20px;margin-bottom:20px">
  <!-- Main table -->
  <table border="0" align="center" cellspacing="0" cellpadding="0" bgcolor="white" width="650">
    <tr>
      <td>
        <!-- Child table -->
        <table border="0" cellspacing="0" cellpadding="0" style="color:#0f3462; font-family: sans-serif;">
          <tr>
          </tr>
         
          <tr>
            <td style="text-align: center;">
              <h1 style="margin: 0px;padding-bottom: 25px;text-transform: capitalize;font-size: 23px;text-align: left;margin-top: 22px;color: black;">Hello !</h1>
              <h2 style="margin: 0px;padding-bottom: 23px;text-transform: capitalize;font-size: 18px;text-align: left;margin-top: 0px;font-weight: 100;color: #a9a8a8;line-height: 30px;"> To ensure the security of your account, please verify your email address with a verification code.</h2>
              <tr>
                <td>
                    <h1 style="margin: 1rem 0">Verification code is {{ $otp }}</h1>
                </td>
              </tr>
            </td>
          </tr>
=
        </table>
        <!-- /Child table -->
      </td>
    </tr>
  </table>
  <!-- / Main table -->
</body>
​
</html>