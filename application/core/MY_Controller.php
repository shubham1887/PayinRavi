<?php defined('BASEPATH') OR exit('No direct script access allowed');

class REST_Controller extends CI_Controller
{
    protected $get      = [];
    protected $post     = [];
    protected $put      = [];
    protected $delete   = [];
    protected $patch    = [];

    public function __construct()
    {
        parent::__construct();

        if ($this->_check_route() === false)
        {
            $resp = [
                'result'    => RESULT_FAIL,
                'data'      => ['message' => 'The api you requested was not found.']
            ];
            return_json($resp, 404);
            return;
        }

        $http_verb = $this->_detect_http_verb();
        $this->_assign_arg($http_verb);
    }

    protected function _check_route()
    {
        $route = null;

        //$routes = array_reverse($this->router->routes);

        /*foreach ($routes as $key => $val)
        {
            $route  = $key;
            $key    = str_replace(array(':any', ':num'), array('[^/]+', '[0-9]+'), $key);

            if (preg_match('#^'.$key.'$#', $this->uri->uri_string(), $matches))
            {
                break;
            }
        }

        if ( ! $route)
        {
            $route = $routes['default_route'];
        }

        $http_verb = $this->_detect_http_verb(true);

        if (is_string($routes[$route]) && $http_verb !== HTTP_VERB_GET)
        {
            return false;
        }

        $match_flag = false;

        if (is_array($routes[$route]))
        {
            foreach ($routes[$route] AS $key => $val)
            {
                $key === $http_verb AND $match_flag = true;
            }
        }
        return $match_flag;
        */
        
    }

    protected function _detect_http_verb($upper = false)
    {
        $method = $this->input->method($upper);
        return $method ? $method : ($upper? strtoupper(HTTP_VERB_GET): strtolower(HTTP_VERB_GET));
    }

    protected function _assign_arg($http_verb = '')
    {
        if (empty($http_verb))
        {
            return false;
        }

        switch(strtoupper($http_verb))
        {
            case HTTP_VERB_GET:
                $this->get = $this->uri->ruri_to_assoc();
                break;

            case HTTP_VERB_POST:
                $this->post = $this->input->post();
                break;

            case HTTP_VERB_PUT:
            case HTTP_VERB_PATCH:
            case HTTP_VERB_DELETE:
                $this->{$http_verb} = $this->input->input_stream();
                break;

            default:
                break;
        }
        return true;
    }
}

class MY_Controller extends REST_Controller
{
    public $token = '';
    public $payload = [];

    public function __construct()
    {
        parent::__construct();

        //$this->load->library(['jwt']);

        $this->load->helper(['security']);
        
        $this->checkAccessRights();
        //$this->split_jwt();

        //echo "herer";exit;
    }
    public function checkAccessRights()
    {
         if ($this->session->userdata('DistUserType') == "Distributor") 
         {
                $arrURI=explode("/",trim(uri_string()));
                $firsturi = trim($arrURI[0]);
                $lasturi = trim($arrURI[count($arrURI)-1]);
                if($firsturi == 'Distributor_new')
                {
                    if($lasturi == "CreateScheme")
                    {
                        error_reporting(-1);
                        ini_set('display_errors',1);
                        $this->db->db_debug = TRUE;
                        $DistId = $this->session->userdata("DistId");
                        $access_rights = $this->db->query("SELECT a.Id,a.rights_for,a.rights_name FROM access_rights a left join access_rights_alloted b on a.Id = b.rights_id  
                            where b.user_id = ? and a.controller_name = ?
                            order by a.Id 
                            ",array($DistId,$lasturi));
                      
                        if($access_rights->num_rows() == 0)
                        {
                            redirect(base_url().$firsturi."/Dashboard");
                        }
                    }
                }
         }
            
        
    }
    public function check_has_rights()
    {
        if($this->userrole=="Admin"){
                $arrURI=explode("/",trim(uri_string()));
                $firsturi = trim($arrURI[0]);
                $lasturi = trim($arrURI[count($arrURI)-1]);
                if($firsturi=="_Admin"){
                    $firsturi.='/'.trim($arrURI[1]);
                }
                if(substr($lasturi,0,4)!="get_" && substr($lasturi,-5)!="_list" && $lasturi!="settings_staff" && $lasturi!="check_pass"){
                    $this->arractmdls=$this->getactivemodules('array');
                    if(!in_array($firsturi,$this->arractmdls)){
                        redirect(base_url().'my404_staff/'); exit;
                    }
                }
        }
    }
    public function split_jwt()
    {
        $this->token = '';
        $this->payload = [];

        $http_verb  = $this->_detect_http_verb();
        $jwt        = $this->{$http_verb};

        if (empty($jwt['data']) || ! is_string($jwt['data'])) {
            return false;
        }

        $explode = explode('.', $jwt['data']);

        $this->token    = $explode[0];
        $this->payload  = empty($explode[1]) ? [] : $this->jwt->decode($explode[1]);

        return true;
    }

    public function __destruct()
    {
    }
}
/* End of file MY_Controller.php */
/* Location: /application/core/MY_Controller.php */