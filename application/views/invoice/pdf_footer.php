<style>
    table.wrap-box{
        width: 100%;
    }

    table.wrap-signature{
        width: 100%;
        text-align: center;
    }
    table.wrap-signature tr td.line-signature{
        border-bottom: 0.5px solid #ccc;
    }
</style>
<table class="wrap-box" cellpadding="20" cellspacing="0">
    <tr>
    <td style="width: 45%;"><table class="wrap-signature" cellpadding="2" cellspacing="0">
                <tr>
                    <td>ในนาม <?=$document['company_name']?></td>
                </tr>
                <tr>
                    <td class="line-signature" colspan="2" style="line-height: 200%;"></td>
                </tr>
                <tr>
                    <td colspan="2">ผู้จ่ายเงิน</td>
                </tr>
                <tr>
                    <td style="width: 20%;">วันที่</td>
                    <td style="width: 80%;" class="line-signature"></td>
                </tr>
            </table>
        </td>

        <td style="width: 10%;"></td>

        <td style="width: 45%;"><table class="wrap-signature" cellpadding="2" cellspacing="0">
                <tr>
                    <td>ในนาม <?=$company['company_name']?></td>
                </tr>
                <tr>
                    <td class="line-signature" colspan="2" style="line-height: 200%;"></td>
                </tr>
                <tr>
                    <td colspan="2">ผู้รับเงิน</td>
                </tr>
                <tr>
                    <td style="width: 20%;">วันที่</td>
                    <td style="width: 80%;" class="line-signature"></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
