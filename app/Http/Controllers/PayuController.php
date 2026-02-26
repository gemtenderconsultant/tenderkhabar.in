<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentSuccessfulNotification;
use App\Models\UserProduct;
use App\Models\User;
use App\Models\TenderUserAccess;
use Session;
use Hash;
use Auth;
use DataTables;
use DB;
use Redirect;

require_once "php_mailer/vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Barryvdh\DomPDF\Facade\Pdf;

class PayuController extends Controller
{
    
    public function payu(Request $request)
        {
            $plan = $request->plan;
            $amount = $request->amount;

            $signature = hash_hmac('sha256', $plan . $amount, config('app.key'));

            return view('payment.payu', [
                'plan'      => $plan,
                'amount'    => $amount,
                'signature' => $signature 
            ]);
        }

    public function pay(Request $request)
        {

            $expectedSignature = hash_hmac('sha256', $request->plan_name . $request->amount, config('app.key'));
            if (!hash_equals($expectedSignature, $request->signature)) {
                return abort(403, 'Security alert: Payment data tampering detected.');
            }

            $MERCHANT_KEY = 'Qh6UVk'; 
            $SALT = 'C2r3CejSZZ3sHssGfSPAogsW9ZWJgR9v';
            $PAYU_BASE_URL = 'https://secure.payu.in/_payment';

            $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
            $amount = number_format((float)$request->amount, 2, '.', '');

            $productinfo = preg_replace('/[^A-Za-z0-9 ]/', '', $request->plan_name);
            $firstname   = preg_replace('/[^A-Za-z0-9 ]/', '', $request->name);
            $email       = trim($request->email);
            $phone       = trim($request->phone);
            $udf1        = preg_replace('/[^A-Za-z0-9 ]/', '', $request->cname) ?: 'NA';
            $udf2        = preg_replace('/[^A-Za-z0-9 ]/', '', $request->gst) ?: 'NA';

            $hashString = $MERCHANT_KEY . '|' . $txnid . '|' . $amount . '|' . $productinfo . '|' . $firstname . '|' . $email . '|' . $udf1 . '|' . $udf2 . '|||||||||' . $SALT;
            
            $hash = strtolower(hash('sha512', $hashString));

            return view('payment.payu_redirect', compact(
                'PAYU_BASE_URL', 
                'MERCHANT_KEY', 
                'txnid', 
                'amount', 
                'productinfo', 
                'firstname', 
                'email', 
                'phone', 
                'udf1', 
                'udf2', 
                'hash'
            ));
        }

    public function success(Request $request)
        {
            $SALT = 'C2r3CejSZZ3sHssGfSPAogsW9ZWJgR9v'; 
            
            $status      = $request->status;
            $firstname   = $request->firstname;
            $amount      = $request->amount;
            $txnid       = $request->txnid;
            $posted_hash = $request->hash;
            $key         = $request->key;
            $productinfo = $request->productinfo;
            $email       = $request->email;
            $udf1        = $request->udf1; // company
            $udf2        = $request->udf2; // gst
            $phone       = $request->phone;
            $payuid      = $request->mihpayid;

            $hashSequence = [
                $SALT, $status, '', '', '', '', '', '', '', '', 
                $udf2, $udf1, $email, $firstname, $productinfo, $amount, $txnid, $key
            ];
            $hash_string = implode('|', $hashSequence);

            if ($request->has('additionalCharges')) {
                $hash_string = $request->additionalCharges . '|' . $hash_string;
            }

            $calculated_hash = strtolower(hash("sha512", $hash_string));

            if ($calculated_hash !== strtolower($posted_hash)) {
                return "Invalid Transaction. Hash Mismatch.";
            }

            $messageBody = '
            <html>
            <body style="font-family: Arial, sans-serif; color: #333;">
                <h2 style="color: #1e3a8a;">New Payment Received!</h2>
                <p>A new transaction has been completed successfully via PayU.</p>
                <table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 600px;">
                    <tr style="background-color: #f8fafc;"><td><strong>Plan:</strong></td><td>'.$productinfo.'</td></tr>
                    <tr><td><strong>Amount:</strong></td><td>₹'.$amount.'</td></tr>
                    <tr style="background-color: #f8fafc;"><td><strong>Customer Name:</strong></td><td>'.$firstname.'</td></tr>
                    <tr><td><strong>Email:</strong></td><td>'.$email.'</td></tr>
                    <tr style="background-color: #f8fafc;"><td><strong>Phone:</strong></td><td>'.$phone.'</td></tr>
                    <tr><td><strong>Company Name:</strong></td><td>'.$udf1.'</td></tr>
                    <tr style="background-color: #f8fafc;"><td><strong>GST Number:</strong></td><td>'.$udf2.'</td></tr>
                    <tr><td><strong>Merchant Txn ID:</strong></td><td>'.$txnid.'</td></tr>
                    <tr style="background-color: #f8fafc;"><td><strong>PayU ID:</strong></td><td>'.$payuid.'</td></tr>
                </table>
                <p>Regards,<br><strong>Team Aarav Tender Consultant PVT. LTD.</strong></p>
            </body>
            </html>';

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.zeptomail.in';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'emailapikey';
                $mail->Password   = 'PHtE6r0KQe/jjjIsoBZSsfXrQJShZ957/u9ueQRFs4ZLA/MHHE1TqIp+l2DlohsjXfMWR/aTwI9t4ruU5+qBJWe+Mz1MWWqyqK3sx/VYSPOZsbq6x00ft18bfkLUVYbmdNBi1y3Rs9jfNA==';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;
                $mail->CharSet    = 'UTF-8';
                // $mail->SMTPDebug = 2;
                // $mail->Debugoutput = 'html';

                $mail->setFrom('noreply@tenderkhabar.com', 'Gem Tender Consultants');
                $mail->addAddress('care@gemtenderconsultant.com');
                $mail->addAddress('sales@gemtenderconsultant.com');
                $mail->addCC('accounts@gemtenderconsultant.com');
                
                $mail->isHTML(true);
                $mail->Subject = 'New Payment: ' . $udf1;
                $mail->Body    = $messageBody;

                $mail->send();
            
            } catch (Exception $e) {
                dd("Mail Error: " . $mail->ErrorInfo); 
            }

            return view('payment.success', $request->all());
        }

    public function failed(Request $request)
        {
            return view('payment.failed', $request->all());
        }

    public function downloadReceipt(Request $request)
        {
            $data = [
                'txnid'   => $request->query('txnid'),
                'name'    => $request->query('name'),
                'cname'   => $request->query('cname'),
                'email'   => $request->query('email'),
                'plan'    => $request->query('plan'),
                'amount'  => $request->query('amount'),
                'date'    => now()->format('d-m-Y h:i A'),
            ];
            $pdf = Pdf::loadView('payment.receipt', compact('data'));

            return $pdf->download('Receipt-'.$data['txnid'].'.pdf');
        }    
    public function singlepayu(Request $request)
    {
        $plan = $request->plan;
        $amount = $request->amount;
        $tenderid = $request->tenderid;

        $signature = hash_hmac('sha256', $plan . $amount, config('app.key'));

        return view('singlepayment.singlepayu', [
            'plan'      => $plan,
            'amount'    => $amount,
            'tenderid'  => $tenderid,
            'signature' => $signature 
        ]);
    }

    public function singlepay(Request $request)
        {
            $expectedSignature = hash_hmac('sha256', $request->plan_name . $request->amount, config('app.key'));
            if (!hash_equals($expectedSignature, $request->signature)) {
                return abort(403, 'Security alert: Payment data tampering detected.');
            }

            $MERCHANT_KEY = 'Qh6UVk'; 
            $SALT = 'C2r3CejSZZ3sHssGfSPAogsW9ZWJgR9v';
            $PAYU_BASE_URL = 'https://secure.payu.in/_payment';

            $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
            $amount = number_format((float)$request->amount, 2, '.', '');
            
            $productinfo = preg_replace('/[^A-Za-z0-9 ]/', '', $request->plan_name);
            $firstname   = preg_replace('/[^A-Za-z0-9 ]/', '', $request->name);
            $email       = trim($request->email);
            $phone       = trim($request->phone);
            $udf1        = preg_replace('/[^A-Za-z0-9 ]/', '', $request->cname) ?: 'NA';
            $udf2        = preg_replace('/[^A-Za-z0-9 ]/', '', $request->gst) ?: 'NA';
            $udf3  =  trim($request->tenderid);
          
            $hashString = $MERCHANT_KEY . '|' . $txnid . '|' . $amount . '|' . $productinfo . '|' . $firstname . '|' . $email . '|' . $udf1 . '|'.  $udf2 . '|' . $udf3  . '||||||||' . $SALT;
            
            $hash = strtolower(hash('sha512', $hashString));

            return view('singlepayment.payu_redirect', compact(
                'PAYU_BASE_URL', 
                'MERCHANT_KEY', 
                'txnid', 
                'amount', 
                'productinfo', 
                'firstname', 
                'email', 
                'phone', 
                'udf1', 
                'udf2', 
                'udf3', 
                'hash'
            ));
        }

    public function singlesuccess(Request $request)
    {
        $SALT = 'C2r3CejSZZ3sHssGfSPAogsW9ZWJgR9v'; 
        
        $status      = $request->status;
        $tenderid    = $request->udf3; // tenderid
        $firstname   = $request->firstname;
        $amount      = $request->amount;
        $txnid       = $request->txnid;
        $posted_hash = $request->hash;
        $key         = $request->key;
        $productinfo = $request->productinfo;
        $email       = $request->email;
        $udf1        = $request->udf1; // company
        $udf2        = $request->udf2; // gst
        $phone       = $request->phone;
        $payuid      = $request->mihpayid;

        $hashSequence = [
            $SALT, $status, '', '', '', '', '', '', '',
            $tenderid,$udf2, $udf1, $email, $firstname, $productinfo, $amount, $txnid, $key
        ];
        $hash_string = implode('|', $hashSequence);

        if ($request->has('additionalCharges')) {
            $hash_string = $request->additionalCharges . '|' . $hash_string;
        }
        $calculated_hash = strtolower(hash("sha512", $hash_string));
        if ($calculated_hash !== strtolower($posted_hash)) {
            return "Invalid Transaction. Hash Mismatch.";
        }
        
        $messageBody = '
        <html>
        <body style="font-family: Arial, sans-serif; color: #333;">
            <h2 style="color: #1e3a8a;">New Payment Received!</h2>
            <p>A new transaction has been completed successfully via PayU.</p>
            <table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 600px;">
                <tr style="background-color: #f8fafc;"><td><strong>GCID:</strong></td><td>'.$tenderid.'</td></tr>
                <tr style="background-color: #f8fafc;"><td><strong>Plan:</strong></td><td>'.$productinfo.'</td></tr>
                <tr><td><strong>Amount:</strong></td><td>₹'.$amount.'</td></tr>
                <tr style="background-color: #f8fafc;"><td><strong>Customer Name:</strong></td><td>'.$firstname.'</td></tr>
                <tr><td><strong>Email:</strong></td><td>'.$email.'</td></tr>
                <tr style="background-color: #f8fafc;"><td><strong>Phone:</strong></td><td>'.$phone.'</td></tr>
                <tr><td><strong>Company Name:</strong></td><td>'.$udf1.'</td></tr>
                <tr style="background-color: #f8fafc;"><td><strong>GST Number:</strong></td><td>'.$udf2.'</td></tr>
                <tr><td><strong>Merchant Txn ID:</strong></td><td>'.$txnid.'</td></tr>
                <tr style="background-color: #f8fafc;"><td><strong>PayU ID:</strong></td><td>'.$payuid.'</td></tr>
            </table>
            <p>Regards,<br><strong>Team Aarav Tender Consultant PVT. LTD.</strong></p>
        </body>
        </html>';

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.zeptomail.in';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'emailapikey';
            $mail->Password   = 'PHtE6r0KQe/jjjIsoBZSsfXrQJShZ957/u9ueQRFs4ZLA/MHHE1TqIp+l2DlohsjXfMWR/aTwI9t4ruU5+qBJWe+Mz1MWWqyqK3sx/VYSPOZsbq6x00ft18bfkLUVYbmdNBi1y3Rs9jfNA==';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';
            // $mail->SMTPDebug = 2;
            // $mail->Debugoutput = 'html';

            $mail->setFrom('noreply@tenderkhabar.com', 'Gem Tender Consultants');
            $mail->addAddress('care@gemtenderconsultant.com');
            $mail->addAddress('sales@gemtenderconsultant.com');
            $mail->addCC('accounts@gemtenderconsultant.com');
            
            $mail->isHTML(true);
            $mail->Subject = 'New Payment: ' . $udf1;
            $mail->Body    = $messageBody;

            $mail->send();
        
        } catch (Exception $e) {
            dd("Mail Error: " . $mail->ErrorInfo); 
        }
        $user = User::where('mobile', $phone)->first();

        if (!$user) {
            $user = User::create([
                'name' => $firstname,
                'email' => $email,
                'company_name' => $udf1,
                'mobile' => $phone,
                'password' => Hash::make($phone),
                'status' => "Paid"
            ]);
        }
        // ✅ AUTO LOGIN USER
        Auth::login($user);
         $clientmessageBody = ' <html>
            <body style="font-family: Arial, sans-serif; color: #333;">
                <h3>Hello, '.$firstname.'</h3>
                <p>Your account at Tenderkhabar (Gem Tender Consultants Pvt. Ltd) has been created successfully.</p>
                <p>Your login credentials are:</p>
                <p>Username: '.$email.'</p>
                <p>Password: '.$phone.'</p>
                <br>
                <h2 style="color: #1e3a8a;">New Payment Received!</h2>
                <p>A new transaction has been completed successfully via PayU.</p>
                <table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 600px;">
                    <tr style="background-color: #f8fafc;"><td><strong>GCID:</strong></td><td>'.$tenderid.'</td></tr>
                    <tr style="background-color: #f8fafc;"><td><strong>Plan:</strong></td><td>'.$productinfo.'</td></tr>
                    <tr><td><strong>Amount:</strong></td><td>₹'.$amount.'</td></tr>
                    <tr style="background-color: #f8fafc;"><td><strong>Customer Name:</strong></td><td>'.$firstname.'</td></tr>
                    <tr><td><strong>Email:</strong></td><td>'.$email.'</td></tr>
                    <tr style="background-color: #f8fafc;"><td><strong>Phone:</strong></td><td>'.$phone.'</td></tr>
                    <tr><td><strong>Company Name:</strong></td><td>'.$udf1.'</td></tr>
                    <tr style="background-color: #f8fafc;"><td><strong>GST Number:</strong></td><td>'.$udf2.'</td></tr>
                    <tr><td><strong>Merchant Txn ID:</strong></td><td>'.$txnid.'</td></tr>
                    <tr style="background-color: #f8fafc;"><td><strong>PayU ID:</strong></td><td>'.$payuid.'</td></tr>
                </table>
                <p>Regards,<br><strong>Team Aarav Tender Consultant PVT. LTD.</strong></p>
            </body>
            </html>';

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.zeptomail.in';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'emailapikey';
                $mail->Password   = 'PHtE6r0KQe/jjjIsoBZSsfXrQJShZ957/u9ueQRFs4ZLA/MHHE1TqIp+l2DlohsjXfMWR/aTwI9t4ruU5+qBJWe+Mz1MWWqyqK3sx/VYSPOZsbq6x00ft18bfkLUVYbmdNBi1y3Rs9jfNA==';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;
                $mail->CharSet    = 'UTF-8';
                // $mail->SMTPDebug = 2;
                // $mail->Debugoutput = 'html';

                $mail->setFrom('noreply@tenderkhabar.com', 'Gem Tender Consultants');
                $mail->addAddress($email);
                $mail->addCC('sales@gemtenderconsultant.com');
                
                $mail->isHTML(true);
                $mail->Subject = 'Account has been created on Tenderkhabar & You are One Tender purchase';
                $mail->Body    = $clientmessageBody;

                $mail->send();
            
            } catch (Exception $e) {
                dd("Mail Error: " . $mail->ErrorInfo); 
            }

        // ✅ TENDER-WISE DOCUMENT ACCESS
        TenderUserAccess::updateOrCreate(
            [
                'user_id' => $user->id,
                'tender_id' => $tenderid,
            ],
            [
                'is_download' => 1
            ]
        );
    // ✅ REDIRECT BACK TO SAME TENDER PAGE
        //  return redirect()->route('tenderviewsingle', $tenderid)
        //              ->with('success','Payment Successful'); 
        return redirect()->route('tenderview', $tenderid)
                     ->with('success','Payment Successful');   
    }
    public function singlefailed(Request $request)
        {
            return view('singlepayment.failed', $request->all());
        }
}

