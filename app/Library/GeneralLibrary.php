<?php


namespace App\Library;


use App\mdDaysOfWeek;
use App\mdDeliveryStoreTimes;
use App\mdRelStoresUsersAdm;
use App\mdStores;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GeneralLibrary
{
    public function storeSelectedByUser($pNotExcept = false )
    {
        $storeUserAdmId = 0;

        if(Session::has('StoresUserAdm')){
            foreach(Session::get('StoresUserAdm') as $store){
                if($store['selected']){
                    $storeUserAdmId = $store['id'];
                }
            }
        } else {
            if($pNotExcept){
                return 0;
            } else {
                throw new \ErrorException('Não existe loja selecionada');
            }
        }

        return $storeUserAdmId;
    }

    public function isUserOfStoreSelected()
    {
        $isUserOfStoreSelected = false;
        $UserAuth = Auth::user();

        $relUsersAdmBystore = User::pesqUserAdmByStore($this->storeSelectedByUser());

        foreach($relUsersAdmBystore as $userAdmByStore){
            if($userAdmByStore->useradm ==  $UserAuth->id){
                $isUserOfStoreSelected = true;
            }
        }

        return $isUserOfStoreSelected;
    }

    public function pesqStoresOfUserAdm($pUserAdm = null)
    {
        $userAuth = Auth::user();
        if(is_null($pUserAdm)){
            $allStoresUserAdm = User::find($userAuth->id)->allStoresByUserAdm;
        } else {
            $allStoresUserAdm = User::find($pUserAdm)->allStoresByUserAdm;
        }

        for ($i = 0; $i < count($allStoresUserAdm); $i++){
            $inStoresUserAdm[$i] = $allStoresUserAdm[$i]->id;
        }

        return $storesUserAdm = mdStores::where('status', 'S')->whereIn('id', $inStoresUserAdm)->orderBy('affiliate','asc')->orderBy('id','asc')->get();
    }

    public function pesqUsersAdmByStores()
    {
        $storesUserAdm = $this->pesqStoresOfUserAdm();

        for ($i = 0; $i < count($storesUserAdm); $i++){
            $inStoresUserAdm[$i] = $storesUserAdm[$i]->id;
        }

        $RelStoresUsersAdm = mdRelStoresUsersAdm::select('useradm')->whereIn('store', $inStoresUserAdm)->groupBy('useradm')->get();

        for ($i = 0; $i < count($RelStoresUsersAdm); $i++){
            $inUsersAdmStore[$i] = $RelStoresUsersAdm[$i]->useradm;
        }

        return $UsersAdm = User::whereIn('id', $inUsersAdmStore)->orderBy('id','asc')->get();
    }

    public function isStoreOpenToDelivery(){

        $daysOfWeek = [
            "Monday"        => "Segunda",
            "Tuesday"       => "Terça",
            "Wednesday"     => "Quarta",
            "Thursday"      => "Quinta",
            "Friday"        => "Sexta",
            "Saturday"      => "Sábado",
            "Sunday"        => "Domingo"
        ];

        $Store = mdStores::where('id', env('APP_STORE_ID'))->first();

        if(strtoupper($Store->status) === 'N' || strtoupper($Store->active_store_site) === 'N'){
            return false;
        } else {
            $dateTymeNow = now();
            $dayOfWeekBR = $daysOfWeek[$dateTymeNow->dayName];
            $dayOfWeekData = mdDaysOfWeek::where('day', '=', $dayOfWeekBR)->first();
            $deliveryTimeDayOfWeek = mdDeliveryStoreTimes::where('store', $Store->id)->where('status', 'S')->where('day', $dayOfWeekData->id)->first();

            if($dateTymeNow->isBetween($deliveryTimeDayOfWeek->periodo1_ini, $deliveryTimeDayOfWeek->periodo1_end) || $dateTymeNow->isBetween($deliveryTimeDayOfWeek->periodo2_ini, $deliveryTimeDayOfWeek->periodo2_end)){
                return true;
            } else {
                return false;
            }
        }
    }

    //Adjuste Phone number
    private function numberAdjust($pNumber, $pAdd9, $pDel9)
    {
        if($pAdd9) {
            //If number has 11 digits do nothing
            if (strlen($pNumber) == 11){
                return $pNumber;
            } else if (strlen($pNumber) == 10){
                //Get DDD and Number
                $ddd = substr($pNumber, 0, 2);
                $num = str_replace($ddd, '', $pNumber);

                //Verify if the number is cell phone, if dont return the self number.
                if ($num[0] == 2 || $num[0] == 3) {
                    return $pNumber;
                }

                //If cell phone and has only 8 number, add 9 number
                if (strlen($num) == 8) {
                    $num = "9{$num}";
                }

                return "{$ddd}{$num}";
            }
        } else if ($pDel9) {
            //If number has 11 digits remove the digit 9
            if (strlen($pNumber) == 11){
                //Get DDD and Number
                $ddd = substr($pNumber, 0, 2);
                $num = str_replace($ddd, '', $pNumber);

                //Verify if the number is cell phone, if dont return the self number.
                if ($num[0] == 2 || $num[0] == 3) {
                    return $pNumber;
                }

                //If cell phone and has 9 digits, remove the digit 9.
                if (strlen($num) == 9) {
                    $num = substr($num, 1, $num);
                }

                return "{$ddd}{$num}";
            } else {
                return $pNumber;
            }
        } else {
            return $pNumber;
        }
    }

    //Clean the number to removed the caracters
    private function numberSanitize($pNumber)
    {
        return preg_replace('/[^0-9]/', '', $pNumber);
    }

    //Adjuste Phone number digit 9
    public function adjustDigitNumberNine($pNumber, $pAdd9=true, $pDel9=false)
    {
        if (empty($pNumber))
            return '';

        $number = $this->numberSanitize($pNumber);
        $number = $this->numberAdjust($number, $pAdd9, $pDel9);

        return $number;
    }

    //Validate Phone Number
    public function validatePhoneNumber($phoneNumber)
    {
        $phoneNumber = trim(str_replace('/', '', str_replace(' ', '', str_replace('-', '', str_replace(')', '', str_replace('(', '', $phoneNumber))))));

        $regexPhone = '/^(?:(?:\+|00)?(55)\s?)?(?:\(?([1-9][0-9])\)?\s?)?(?:((?:9\d|[2-9])\d{3})\-?(\d{4}))$/'; // Regex para validar somente celular

        if (preg_match($regexPhone, $phoneNumber)) {
            return true;
        } else {
            return false;
        }
    }
}
