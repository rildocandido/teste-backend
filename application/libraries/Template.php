<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

   class Template{

        function show($view, $data=array()){

             $CI = & get_instance();
             
             // Carrega o header
             $CI->load->view('template/header', $data);

             // Carrega o conteúdo 
             $CI->load->view($view, $data);

             // Carrega o footer 
             $CI->load->view('template/footer', $data);

             // Carrega os Scripts
             $CI->load->view('template/scripts', $data); 
        }

   }

  /* End of file Template.php */
  /* Location: ./system/application/libraries/Template.php */ 