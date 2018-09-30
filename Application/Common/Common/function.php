<?php
/**
 * 公共函数
 * @author: liuxuchao <liuxuchao126@126.com>
 * @date: 2017年03月15日 11:10
 */


    /**
     * 发送邮件
     * @author: liuxuchao <liuxuchao126@126.com>
     * @param: string $email
     * @param: string $content
     * @param: string $title
     * @date: 2017年3月15日11:26:13
     * @return bool|mixed
     */
    function sendEmail($email, $content, $title){ //发送邮件
        vendor('PHPMailer.PHPMailerAutoload');
        $mail = new \PHPMailer();
        //$randNum = mt_rand(1,3);
        $fromNum = mt_rand(0,6);
        $randNum = 1;
        $emailData = C('EMAILCONFIG');
        $emailConf = $emailData[$randNum];
        $fromArr = $emailConf['from'];
        $title = str_replace('{fromname}',$emailConf['fromname'],$title);
        $mail->IsSMTP(); // 使用SMTP方式发送
        $mail->CharSet= $emailConf['charset'];// 设置邮件的字符编码
        $mail->Host = $emailConf['host']; // 您的企业邮局服务器
        $mail->Port = $emailConf['port']; // 设置端口
        $mail->SMTPAuth = true; // 启用SMTP验证功能
        $mail->Username = $emailConf['username']; // 邮局用户名(请填写完整的email地址)
        $mail->Password = $emailConf['password']; // 邮局密码
        $mail->From = $fromArr[$fromNum]; //邮件发送者email地址
        $mail->FromName = $emailConf['fromname'];
        $toemail = $email?$email:'812176460@qq.com';
        $mail->AddAddress($toemail);//收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")
        $mail->IsHTML(true); // set email format to HTML //是否使用HTML格式
        $mail->Subject = $title;//"PHPMailer测试邮件"; //邮件标题
        $mail->Body = $content; //邮件内容
        if(!$mail->Send()){
            return false;
        }else{
            return true;
        }
    }

    /**
     * @tips：获取Excel中的数据
     * @author: liuxuchao <liuxuchao126@126.com>
     * @date: 2017年3月15日11:26:13
     * @param: $filePath服务器下的文件路径
     * @return array
     * */
    function getArrByPhpExcel($filePath){
        vendor('Excel.PHPExcel');
        $PHPExcel_IOFactory= new \PHPExcel_IOFactory();
        $fileType = $PHPExcel_IOFactory->identify($filePath); //文件名自动判断文件类型
        $objReader = $PHPExcel_IOFactory->createReader($fileType);
        $objPHPExcel = $objReader->load($filePath);
        $currentSheet = $objPHPExcel->getSheet(0); //第一个工作簿
        /**取得最大的列号*/
        $allColumn = $currentSheet->getHighestColumn();
        /**取得一共有多少行*/
        $allRow = $currentSheet->getHighestRow();
        // 一次读取一列
        $data=array();
        //循环读取每个单元格的内容。注意行从1开始，列从A开始
        for($rowIndex=1;$rowIndex<=$allRow;$rowIndex++){
            for($colIndex='A';$colIndex<=$allColumn;$colIndex++){
                $addr = $colIndex.$rowIndex;
                $cell = $currentSheet->getCell($addr)->getValue();
                if($cell instanceof PHPExcel_RichText){ //富文本转换字符串
                    $cell = $cell->__toString();
                }
                $data[$rowIndex][$colIndex] = $cell;
            }
        }
        return $data;
    }
 
    
     /**
     *  发送 邀请邮件
     * @author: liuxuchao <liuxuchao@lxcta.com>
     * @param: string $formEmail  发送者的邮箱
     * @param: string $toEmail  接收者的邮箱
     * @param: string $content  邮件内容
     * @param: string $title    邮件标题
     * @param: string $fromName  发送者名称
     * @date: 2017年6月02日17:26:13
     * @return bool|mixed
     */
    function inviteSendEmail($formEmail, $toEmail, $content, $title, $fromName){ //发送邮件
        vendor('PHPMailer.PHPMailerAutoload');
        $mail = new \PHPMailer();
        $randNum = 1;
        $emailData = C('EMAILCONFIG');
        $emailConf = $emailData[$randNum];
        $mail->IsSMTP(); // 使用SMTP方式发送
        $mail->CharSet= $emailConf['charset'];// 设置邮件的字符编码
        $mail->Host = $emailConf['host']; // 您的企业邮局服务器
        $mail->Port = $emailConf['port']; // 设置端口
        $mail->SMTPAuth = true; // 启用SMTP验证功能
        $mail->Username = $emailConf['username']; // 邮局用户名(请填写完整的email地址)
        $mail->Password = $emailConf['password']; // 邮局密码
        $mail->From = $formEmail; //邮件发送者email地址
        $mail->FromName = $fromName;
        $mail->AddAddress($toEmail);//收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")
        $mail->IsHTML(true); // set email format to HTML //是否使用HTML格式
        $mail->Subject = $title;//"PHPMailer测试邮件"; //邮件标题
        $mail->Body = $content; //邮件内容
        if(!$mail->Send()){
            return false;
        }else{
            return true;
        }
    }