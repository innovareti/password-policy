<html>
    <head>
        <title></title>
    </head>
    <body>
        <table style="table-layout:inherit !important;width:525px;margin-right:auto;margin-left:auto;">
            <thead>
                <tr>
                    <th colspan="2" style="height:25px;background-color:#2ea2cd;"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding:28px;text-align:center;vertical-align:center;border-bottom:1px solid #2ea2cd">
                        <img src="https://humanflow.com.br/onboarding/images/logo-innovare-dark.png" width="185px">
                    </td>
                </tr>
                <tr>
                    <td style="text-align:left;padding:14px;border-bottom:1px solid #2ea2cd">
                        <p style="font-size:16px;font-family:'Calibri Light', sans-serif !important;margin:0;">
                            <b>Olá {{ $mail['name'] }}!</b></p>
                        <p style="font-family:'Calibri Light', sans-serif !important;font-size:14px;">
                            Uma solicitação de alteração de senha foi enviada para o e-mail em questão. Para trocar a senha, basta <a href="{{ $mail['link'] }}">clicar aqui</a>.
                        </p>
                        <p style="font-family:'Calibri Light', sans-serif !important;font-size:14px;">Atenciosamente, <br>
                            <b>InnovareTI.</b></p>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="height:20px;background-color:#2ea2cd"></td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>