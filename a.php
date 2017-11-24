
<?php 
      echo "<pre>";

$a = getRedirect("http://www.bestbuy.com/");
echo $a;


function getRedirect($url,$count = 0){
        if($count>3)
        {

                return $url;
        }
        // create curl resource 
        $ch = curl_init(); 
      
        // set url 
        curl_setopt($ch, CURLOPT_URL, $url); 

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
           curl_setopt($ch,CURLOPT_FOLLOWLOCATION,0); 
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        $headers[] = 'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8';
        $headers[] = 'Accept-Encoding:gzip, deflate, sdch';
        $headers[] = 'Accept-Language:es-CO,es;q=0.8,en-US;q=0.6,en;q=0.4,es-419;q=0.2,pt;q=0.2';
        $headers[] = 'Cache-Control:no-cache';
        $headers[] = 'Upgrade-Insecure-Requests:1';
        $headers[] = 'bm_sv=F63FFAAD8DFFDC397D4F8D6719E91873~uWaE7ASxaoO0N7l5RpsTxnhzX1Q4wlJgm76tZkfGE7abPDVClxOafoR7hdOK3uYXPDAPoDUqQ7uYG8/QAhSYe7+Qb9/KJ18/24N+TK1vGWfjQSlNaJgaJump3oUcD9ABsC5daAQiY6h0bLyytRnD+RO0Jh5dBvBTfQ9IVpohmvw=; Domain=.bestbuy.com; Path=/; Max-Age=5876; HttpOnly';

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // times out after 4s
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:11.0) Gecko/20100101 Firefox/11.0"); 
      $cookie_jar = tempnam('/tmp','cookie');
      
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);
       



        $ody = curl_exec($ch);
        $info = curl_getinfo($ch);
        
     
                print_r( $ody );
                print_r( $info );
       return $url;
        
}
?>