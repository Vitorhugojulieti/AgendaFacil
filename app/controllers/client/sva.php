<?php
namespace app\controllers\client;
use app\interfaces\ControllerInterface;
use app\models\database\Db;
use app\models\Schedule;
use app\models\Service;
use app\models\Company;
use app\models\Collaborator;
use app\classes\Validate;
use app\classes\BlockNotAdmin;
use app\classes\Flash;
use app\classes\Cart;
use app\classes\Breadcrumb;
use app\classes\MercadoPagoIntegration;
use Ramsey\Uuid\Uuid;


class ScheduleController implements ControllerInterface{
    public array $data = [];
    public string $view;
    public string $master = 'master.php';

    public function index(array $args){
        verifySession();

        $db = new Db();
        $db->connect();
        // var_dump('agendouuuu');
        // die();
   
        // $schedules = new Schedule();
        // $schedules = $schedules->getByClient($db,$_SESSION['user']->getId());

        // if(isset($args)){
        //     if(count($args) > 0){
        //         if($args[0] === "status"){
        //             $schedules = $this->filterByStatus($schedules,ucfirst($args[1]));
        //             var_dump($schedules);

        //         }
        //     }
        // }

        $this->view = 'client/agenda.php';
        $this->data = [
            'title'=>'Agenda | AgendaFacil',
            // 'schedules'=>$schedules,
            'location'=> isset($_SESSION['location']) ? $_SESSION['location']['localidade'].'-'.$_SESSION['location']['uf'] : 'Não encontrado!',
            'breadcrumb'=>Breadcrumb::get()
        ];
    }

    private function filterByStatus(array $schedules,String $status){
        $filteredArray = []; 
        foreach ($schedules as $schedule) {
            if($schedule->getStatus() === $status){
                array_push($filteredArray,$schedule);
            }
        }
        return $filteredArray;
    }

    private function filterByData(array $schedules,\DataTime $data){
        $schedules = array_map(function($schedule) {
            return $schedule->getDateSchedule() === $data;
        }, $schedules);
    }

    public function edit(array $args){
   

    }

    public function show(array $args){
        verifySession();

        $db = new Db();
        $db->connect();
        // var_dump('agendouuuu');
        // die();
        $schedule = new Schedule();
        $schedule = $schedule->getById($db,intval($args[0]));

        $this->view = 'client/showSchedule.php';
        $this->data = [
            'title'=>'Detalhes agendamento | AgendaFacil',
            'schedule'=>$schedule,
            'location'=> isset($_SESSION['location']) ? $_SESSION['location']['localidade'].'-'.$_SESSION['location']['uf'] : 'Não encontrado!',
            'breadcrumb'=>Breadcrumb::get()
        ];
    }

    public function update(array $args){
     
    }

    public function removeToCart(array $args){
        Cart::remove(intval($args[0]));
        return redirect('/schedule/store');
    }

    public function store(array $args){
        verifySession();

        $db = new Db();
        $db->connect();
        $serviceManager = new Service();
        
        
        if(isset($args[0])){
            $service = $serviceManager->getById($db,intval($args[0]));
            if($service){
                Cart::add($service);
            }
            $collaborators = $this->getCollaboratorsByServices($db,Cart::get(),Cart::getIdCompany());
            $idCompany = Cart::getIdCompany();
        }

        if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
            //get services for modal add service
            $collaborators = $this->getCollaboratorsByServices($db,Cart::get(),Cart::getIdCompany());
            $services = $serviceManager->getByCompany($db,Cart::getIdCompany());
            $servicesNotInCart = [];
            foreach ($services as $service) {
                if(!Cart::inToCart($service)){
                    array_push($servicesNotInCart,$service);
                }
            }

            $amount = Cart::getAmount();
            $services = Cart::get();
        }else{
            return redirect('/');
        }
      


        $this->view = 'client/storeSchedule.php';
        $this->data = [
            'title'=>'Realizar agendamento | AgendaFacil',
            'navActive'=>'Agenda',
            'collaborators'=>isset($collaborators) ? $collaborators : [],
            'services'=>isset($services) ? $services : [],
            'amount'=>isset($amount) ? $amount : '0.00',
            'servicesCompany'=> isset($servicesNotInCart) ? $servicesNotInCart : [],
            'location'=> isset($_SESSION['location']) ? $_SESSION['location']['localidade'].'-'.$_SESSION['location']['uf'] : 'Não encontrado!',

        ];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(Cart::get()){
                $db = new Db();
                $db->connect();

                $validateData = $this->validateScheduleData();
                $valdateServices = $this->validateServices();
                $validateCollaborators = $this->validateCollaborators();

                if(!$validateData){
                    Flash::set('resultInsertSchedule', 'Erro ao agendar serviço!','notification error');

                    // return redirect("/schedule/store");
                }

                $schedule = $this->registerSchedule($db,$validateData,$_SESSION['user']->getId(),Cart::getIdCompany());
                $services = $this->registerServices($db,$schedule->getId(),Cart::get());   
                $collaborators = $this->registerCollaborators($db,$schedule->getId(),$_POST['collaborators'],Cart::getIdCompany());  
            
             
                if(!$schedule || !$services || !$collaborators){
                    Flash::set('resultInsertSchedule', 'Erro ao agendar serviço!','message error');
                    // return redirect("/schedule/store");
                }

                return redirect("/schedule/paymentSchedule/card/".$schedule->getTotalPaid());
            }
        }
    }

    
    public function getSchedules(){
        //evita erros com o mvc
        $this->master = 'masterapi.php';
        $this->view = 'api.php';
        $this->data = [
            'title'=>'api',
        ];

        if (isset($_GET['day']) && isset($_GET['month']) ) {
            // if (isset($_GET['day']) && isset($_GET['month']) && isset($_SESSION['user']) && isset($_SESSION['auth'])) {
            // returnin ['schedules'=> $schedulesDayForMonth];
            $day = intval($_GET['day']);
            $month = intval($_GET['month']);

            $date = new \DateTime();
            $date->setDate(date('Y'), $month, $day);
            $date->setTime(0, 0, 0);

            $db = new Db();
            $db->connect();

            $schedules = new Schedule();
            $schedules = $schedules->getByClient($db,1);
            // $schedules = $schedules->getByClient($db,$_SESSION['user']->getId());
            
            $schedules = array_filter($schedules, fn($schedule) => $schedule->getDateSchedule() == $date);

            header('Content-Type: application/json');
            echo json_encode($schedules);
            exit();
        }else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Parameter "day" and "month" is required']);
        }
    }


    public function getAvailableTimes(){
        //evita erros com o mvc
        $this->master = 'masterapi.php';
        $this->view = 'api.php';
        $this->data = [
            'title'=>'api',
        ];

        header("Access-Control-Allow-Origin:  http://localhost:8889");
        header("Access-Control-Allow-Methods: GET, POST");


        if (isset($_GET['day'])) {
            $db = new Db();
            $db->connect();

            $day = intval($_GET['day']);
            $cart = Cart::get();
            $amountServicesTime = $this->calculateTotalTime($cart);
      
            $intervalString = "PT{$amountServicesTime->i}M";
            $amountServicesTime = new \DateInterval($intervalString);
        
            $company = new Company;
            $company = $company->getById($db,Cart::getIdCompany());
  
            $intervalsMorning = $this->generateIntervals($company->getOpeningHoursMorningStart(), $company->getOpeningHoursMorningEnd(), $amountServicesTime);
            $intervalsAfternoon = $this->generateIntervals($company->getOpeningHoursAfternoonStart(), $company->getOpeningHoursAfternoonEnd(), $amountServicesTime);
         
            $scheduledTimes = new Schedule();
            $scheduledTimes = $scheduledTimes->getScheduledTimes($db, $day,Cart::getIdCompany());
        
            $availableTimes = ['morning'=>[],'afternoon'=>[]];
            foreach ($intervalsMorning as $interval) {
                if (!$this->isScheduled($interval, $scheduledTimes, $amountServicesTime)) {
                    array_push($availableTimes['morning'],$interval);
                }
            }

            foreach ($intervalsAfternoon as $interval) {
                if (!$this->isScheduled($interval, $scheduledTimes, $amountServicesTime)) {
                    array_push($availableTimes['afternoon'],$interval);
                }
            }

            header('Content-Type: application/json');
            echo json_encode($availableTimes);
            exit();
        }else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Parameter "day" is required']);
        }
    }

   

    public function isScheduled($interval, $blockedIntervals, \DateInterval $amountServicesTime) {
        $intervalStart = $interval;
        $intervalEnd = clone $intervalStart;

        $intervalEnd->add($amountServicesTime);
        foreach ($blockedIntervals as $blocked) {

            $blocked = $blocked->format('H:i');

            if ($intervalStart < $blockEnd && $intervalEnd > $blockStart) {
                return true;
            }
        }
        return false;
    }

    private function calculateTotalTime(array $services) {
        $totalTime = new \DateInterval('PT0H0M');
        $now = new \DateTime();
        $baseDateTime =new \DateTime($now->format('Y-m-d') . ' 00:00:00');
        // var_dump($baseDateTime);
        // die();
    
        foreach ($services as $service) {
            $duration = $service->getDuration(); // Isso é um DateTime
            
            // Calcula a diferença entre a baseDateTime e a duração
            $interval = $baseDateTime->diff($duration);
            
            // Adiciona o intervalo à totalTime
            $totalTime->h += $interval->h;
            $totalTime->i += $interval->i;
            $totalTime->s += $interval->s;
    
            // Normaliza o tempo
            if ($totalTime->s >= 60) {
                $totalTime->i += intdiv($totalTime->s, 60);
                $totalTime->s %= 60;
            }
            if ($totalTime->i >= 60) {
                $totalTime->h += intdiv($totalTime->i, 60);
                $totalTime->i %= 60;
            }
        }
    
        return $totalTime;
    }
 
    function generateIntervals(\DateTime $start, \DateTime $end, \DateInterval $interval) {
        $intervals = [];
        $current = clone $start;
        while ($current < $end) {
            $intervals[] = $current;
            $current->add($interval);
        }
        if ($current->format('H:i') !== $end->format('H:i')) {
            $intervals[] = $end;
        }
        return $intervals;
    }
    
    private function validateScheduleData(){
        $validate = new Validate();
        $validate->handle([
            'day'=>[REQUIRED,DATE],
            'time'=>[REQUIRED,TIME],
        ],'schedule');
      
        if($validate->errors) {
            return false;
        }
        return $validate;
    }

    private function validateServices(){
        return Cart::get() != 0;
    }

    private function validateCollaborators(){
        return count($_POST['collaborators']) != 0;
    }
    
    private function registerSchedule($db,$validateData,$idClient,$idCompany){
        $durationServices = $this->calculateTotalTime(Cart::get());
        
        $endTime =  $validateData->data['time'];
        $endTime->add($durationServices);

        $schedule = new Schedule($idClient,
            $idCompany,
            0,10,0,'',
            'obs',
            'Aguardando pagamento',
            $validateData->data['time'],
            $endTime,
            $validateData->data['day']);
           
        $schedule->insert($db);
        $schedule = $schedule->getByDataTime($db,$validateData->data['day'],$validateData->data['time'],$idCompany);
        return $schedule ? $schedule : false;
    }

    private function registerServices(Db $db,$idSchedule,$services){
        $ok = true; 
        foreach ($services as $service) {
            if(!Schedule::insertScheduleHasServices($db,$idSchedule,$service->getId(),$service->getIdCompany())){
                $ok = false;
            }
        }
       return $ok;
    }

    private function registerCollaborators($db,$idSchedule,$collaborators,$idCompany){
        $ok = true; 
        foreach ($collaborators as $collaborator) {
            if(!Schedule::insertScheduleHasCollaborators($db,$idSchedule,$collaborator,$idCompany)){
                $ok = false;
            }
        }
       return $ok;
    }

    public function postPayment(){
        $this->master = 'masterapi.php';
        $this->view = 'api.php';
        $this->data = [
            'title'=>'api',
        ];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($body->token)){
                $idempotencyKey = Uuid::uuid4()->toString();
                $curl = curl_init();
            
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.mercadopago.com/v1/payments',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    // Formatação correta do JSON com variáveis PHP
                    CURLOPT_POSTFIELDS => json_encode(array(
                        "description" => "Payment for product",
                        "installments" => $body->installments,
                        "payer" => array(
                            "email" => $body->payer->email,
                            "identification" => array(
                                "type" => $body->payer->identification->type,
                                "number" => $body->payer->identification->number
                            )
                        ),
                        "issuer_id" => $body->issuer_id,
                        "payment_method_id" => $body->payment_method_id,
                        "token" => $body->token,
                        "transaction_amount" => $body->transaction_amount
                    )),
                    // Cabeçalhos com a chave de idempotência adicionada corretamente
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'Authorization: Bearer '.$_ENV['ACESSSTOKEN'],
                        'X-Idempotency-Key: '.$idempotencyKey // Correção na concatenação
                    ),
                ));
                
                $response = curl_exec($curl);
                $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                
                if ($response === false) {
                    $error = curl_error($curl);
                    echo "cURL Error: $error";
                } elseif ($http_code !== 200) {
                    echo "HTTP Error: $http_code - Response: $response";
                } else {
                    // Tente decodificar o JSON apenas se a resposta não estiver vazia
                    if (!empty($response)) {
                        $json_response = json_decode($response, true);
                        
                        if (json_last_error() === JSON_ERROR_NONE) {
                            echo json_encode($json_response, JSON_PRETTY_PRINT);
                        } else {
                            echo "Invalid JSON: " . json_last_error_msg();
                        }
                    } else {
                        echo "Empty response from API.";
                    }
                }
                
                curl_close($curl);
            }
        }




    }

    public function paymentSchedule(array $args){
      
        
        $this->view = 'client/payment.php';
        $this->data = [
            'title'=>'Realizar agendamento | AgendaFacil',
            'navActive'=>'Agenda',
            'location'=> isset($_SESSION['location']) ? $_SESSION['location']['localidade'].'-'.$_SESSION['location']['uf'] : 'Não encontrado!',
        ];



        $scheduleId = 2;

        $mercadoPago = new MercadoPagoIntegration($_ENV['ACESSSTOKEN']);

        if(isset($args)){
            $amount = floatval($args[1]);
        }
        var_dump($amount);

        if ($scheduleId) {
            $paymentData = $mercadoPago->createPayment($amount,$scheduleId);

            var_dump($paymentData);
            if ($paymentData) {
                $preferenceId = $paymentData['preference_id'];
                $externalReference = $paymentData['external_reference'];

                echo "<h3>{$amount} #{$externalReference}</h3> <br />";
                if (in_array('card',$args)) {
                    echo "<input type='hidden' id='amount' value='{$amount}'>";
                    echo "<input type='hidden' id='preference_id' value='{$preferenceId}'>";
                    echo "<input type='hidden' id='external_reference' value='{$externalReference}'>";
                } else {
                    // Redirect to the checkout page
                    redirect('/schedule/store');
                }
            } else {
                // Handle payment creation failure
                echo 'Error creating payment';
            }
        } else {
            // Handle payment addition failure
            echo 'Error adding payment';
        }

    }

    public function destroy(array $args){
        BlockNotAdmin::block($this,['destroy']);

        if(isset($args)){

            $db = new Db();
            $db->connect();
    
            $service = new Service();
            if($service->delete($db,intval($args[0]))){
                Flash::set('reultDeleteService', 'Erro ao excluir colaborador!','message sucess');
                return redirect("/admin/service");
            }

            Flash::set('reultDeleteService', 'Erro ao excluir colaborador!','message error');
            return redirect("/admin/service");
        }
    }
}

?>