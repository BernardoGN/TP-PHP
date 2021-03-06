<?php
    class ReservaDao{

        // Escrita //
        function insert($reserva){
            $reservaJSON = json_encode($reserva);
            $ArquivoJSON = file_get_contents("Arquivos/reservas.json");
            if($ArquivoJSON == "[]"){ // Nenhum usuario cadastrado
                $ArquivoJSON = str_replace("[", "[".$reservaJSON, $ArquivoJSON);
            }else{
                $ArquivoJSON = str_replace("[", "[".$reservaJSON.",", $ArquivoJSON);
            }

            $file = fopen("Arquivos/reservas.json", "w");
            fwrite($file, $ArquivoJSON);
            fclose($file); 
        }

        function delete($reserva){
            $ArquivoJSON = file_get_contents("Arquivos/reservas.json");
            $reservaJSON = json_encode($reserva);
            
            if (strpos($ArquivoJSON, "[".$reservaJSON."]") !== false){ // Nenhum usuario cadastrado
                $ArquivoJSON = str_replace($reservaJSON, "", $ArquivoJSON);
            }else if(strpos($ArquivoJSON, "[".$reservaJSON) !== false){ // É a primeira reserva
                $ArquivoJSON = str_replace($reservaJSON . ",", "", $ArquivoJSON);
            }else{
                $ArquivoJSON = str_replace(",".$reservaJSON, "", $ArquivoJSON);
            }

            $file = fopen("Arquivos/reservas.json", "w");
            fwrite($file, $ArquivoJSON);
            fclose($file); 
        }


        // Leitura //
        function read_by_place($espaco){
            $reservas;
            $todas_reservas = json_decode(file_get_contents("Arquivos/reservas.json"));
            foreach ( $todas_reservas as $r ) {
                if ($r->espaco == $espaco){
                    $reservas[] = new Reserva($r->matricula, $r->espaco, $r->tipo_de_reserva, $r->data, $r->inicio, $r->fim);
                }
            }
            return $reservas;
        }

        function read_by_matricula($matricula){
            $reservas = null;
            $todas_reservas = json_decode(file_get_contents("Arquivos/reservas.json"));
            foreach ( $todas_reservas as $r ) {
                if ($r->matricula == $matricula){
                    $reservas[] = new Reserva($r->matricula, $r->espaco, $r->tipo_de_reserva, $r->data, $r->inicio, $r->fim);
                }
            }
            return $reservas;
        }
    }

?>