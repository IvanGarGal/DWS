/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package util;

import java.net.InetAddress;
import java.net.UnknownHostException;
import java.security.SecureRandom;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.Calendar;
import java.util.Date;
import java.util.Random;
import java.util.Timer;
import java.util.TimerTask;
import servicios.UserLogin;

/**
 *
 * @author oscar
 */
public class Utils {

    private static final String ALPHA_NUMERIC_STRING = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    public static String randomAlphaNumeric(int count) {
        StringBuilder builder = new StringBuilder();
        Random r = new SecureRandom();

        while (count-- != 0) {
            int character = (int) (r.nextInt(ALPHA_NUMERIC_STRING.length()));
            builder.append(ALPHA_NUMERIC_STRING.charAt(character));
        }
        return builder.toString();
    }

    /**
     * Obtenemos la fecha y hora actual y la formateamos
     *
     * @return devuelve la decha formateada en String
     */
    public static Date format_fecha() {

        /*LocalDateTime now = LocalDateTime.now();
        DateTimeFormatter formatter = DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:ss");
        String formatDateTime = now.format(formatter);
        Date date = formatter.parse(formatDateTime);
        System.out.println("formato de fecha: " + date);*/
        Date today = Calendar.getInstance().getTime();
        return today;
    }
    
    //10 minustos para la activacion del temporizador
    static final long MINUTOS = 600000;

    public static void iniciarTemporizador(final String nombre) {
        Timer time = new Timer();
        TimerTask task = new TimerTask() {
            @Override
            public void run() {
                UserLogin login = new UserLogin();
                int state = login.esActivo(nombre);
                if(state==1){
                    System.out.println("El usuario ha sido eliminado");
                }else{
                    System.out.println("El usuario no ha sido borrado");
                }
            }
        };

        time.schedule(task, MINUTOS);

    }
}
