<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TokenContoller extends Controller
{
    // protected $company_token = env('COMPANY_TOKEN', '');
    // protected $current_time=time();

    public function createCURL( $input_xml )
    {

        $url = 'https://secure1.sandbox.directpay.online/API/v6/';

        $ch = curl_init();

        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_SSLVERSION, 6 );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: text/xml' ) );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $input_xml );

        $response = curl_exec( $ch );

        curl_close( $ch );

        return $response;
    }

    public function chargeTokenwithMNO (Request $request){
        $transaction_token = $request->input('transaction_token');
        $mobile_number = $request->input('mobile');
        $mno = $request->input('mno');
        $country = $request->input('country');
        $request_xml = '
        <?xml version="1.0" encoding="UTF-8"?>
        <API3G>
         <CompanyToken>' . env('COMPANY_TOKEN', '') . '</CompanyToken>
           <Request>ChargeTokenMobile</Request>
           <TransactionToken>'.$transaction_token.'</TransactionToken>
           <PhoneNumber>'.$mobile_number.'</PhoneNumber>
           <MNO>'.$mno.'</MNO>
           <MNOcountry>'.$country.'</MNOcountry>
        </API3G>
        ';

        $response = $this->createCURL( $request_xml );

        return response()->json($response,200);
    }


    public function getMNOpaymentOptions(Request $request){
        $transaction_token = $request->input('transaction_token');
        $request_xml='<?xml version="1.0" encoding="utf-8"?>
        <API3G>
        <CompanyToken>' . env('COMPANY_TOKEN', ''). '</CompanyToken>
            <Request>GetMobilePaymentOptions</Request>
            <TransactionToken>'.$transaction_token.'</TransactionToken>
      </API3G>
        ';

        $response = $this->createCURL( $request_xml );

        return response()->json($response,200);
    }

    
    public function create(){

        $request_xml = '<?xml version="1.0" encoding="utf-8"?>
                 <API3G>
        <CompanyToken>' . env('COMPANY_TOKEN', ''). '</CompanyToken>
        <Request>createToken</Request>
        <Transaction>
            <PaymentAmount>5000</PaymentAmount>
            <PaymentCurrency>TZS</PaymentCurrency>
            <CompanyRef>49FKEOA</CompanyRef>
            <RedirectURL>http://www.yourdomain.com/payurl.php</RedirectURL>
            <BackURL>http://www.yourdomain.com/backurl.php </BackURL>
            <CompanyRefUnique>0</CompanyRefUnique>
            <PTL>1</PTL>
        </Transaction>
        <Services>
            <Service>
                <ServiceType>5525</ServiceType>
                <ServiceDescription>DPO API Intergration Service</ServiceDescription>
                <ServiceDate>' . date("Y/m/d H:i",time()).'</ServiceDate>
            </Service>
            </Services>
            </API3G>
        ';

        $response = $this->createCURL( $request_xml );

        return response()->json($response,201);

    }
}
