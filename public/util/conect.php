<?php
                // Datos de la base de datos
                            define('DB_HOSTp',"localhost");
                            define('DB_USERp',"bqwdxwfh_root");
                            define('DB_PASSp','LH[b5w*8jOUG');
                            define('DB_NAMEp',"bqwdxwfh_pos");
                            
                            /*Dominio donde se alojan los correos de la empresa
                            Ejemplo: hotmail.com
                                     gmail.com
                                     outlook.com*/
                            define('DOMINIO_SMTP','@'.'multi-marcas.com');
                            
                            // Datos de conexion a servidor SMTP
                            define('HOST_SMTP','mail.multi-marcas.com');    /*Servidor SMTP*/
                            define('SECURE_SMTP','');   /*Protocolo SSL o TLS*/
                            define('PORT_SMTP','587');   /*Puerto de conexión al servidor SMTP*/
                            define('AUTH_SMTP','true');   /*Para habilitar o deshabilitar la autenticación*/
                            define('USERNAME_SMTP','mail@multi-marcas.com');   /*Usuario, normalmente el correo electrónico*/
                            define('PASSWORD_SMTP','*Mm.com/*0*');   /*Tu contraseña*/
                            define('FROM_SMTP','mail@multi-marcas.com');   /*Correo electrónico que estamos autenticando*/
                            define('FROM_NAME_SMTP','MULTI MARCAS');   /*Puedes poner tu nombre, el de tu empresa, nombre de tu web, etc.*/
                            define('COD_SMTP','UTF-8');   /*Codificación del mensaje*/
                            
                  

                            // Comando de conexion establesida m1
                            try
                            {
                            $dbP = new PDO("mysql:host=".DB_HOSTp.";dbname=".DB_NAMEp,DB_USERp, DB_PASSp,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
                            }
                            catch (PDOException $eP)
                            {
                            exit("Error: " . $eP->getMessage());


                            } 

                                    
        ?>