/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package servicios;

import config.Configuration;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.apache.commons.mail.Email;
import org.apache.commons.mail.EmailException;
import org.apache.commons.mail.SimpleEmail;

/**
 *
 * @author Miguel Angel Diaz
 */
public class MailServicios {

    public void mandarMail(String to, String msg, String subject) {
        try {

            Email email = new SimpleEmail();

            email.setHostName(Configuration.getInstance().getSmtpServer());
            email.setSmtpPort(Integer.parseInt(Configuration.getInstance().getSmtpPort()));
            email.setAuthentication(Configuration.getInstance().getMailFrom(), Configuration.getInstance().getMailPass());
            email.setStartTLSEnabled(true);

            //El correo siempre muestra el MailFrom del archivo de configuracion
            email.setFrom(Configuration.getInstance().getMailFrom());

            /*En algunos correos te muestra el MailFrom que tu le pongas.
            En otros como Gmail, aunque el correo se envía sin problemas, te mostrará 
            siempre el MailFrom del archivo de configuracion*/
            //email.setFrom("prueba@iesquevedo.es");
            email.setSubject(subject);
            email.setContent("<html>"
                    + "<body>"
                    + "<h1>Registro <strong>completado</strong></h1>"
                    + "<p>Muchas gracias por registrarte.</p>"
                    + "<p>Haz click en el siguiente enlace para activar tu cuenta.</p>"
                    + "<a href='" + msg + "'>Activar</a>"
                    + "</body>"
                    + "</html>", "text/html");
            //email.setMsg(msg);
            email.addTo(to);

            email.send();
        } catch (EmailException ex) {
            System.out.println(ex.getMessage());
            Logger.getLogger(MailServicios.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
}
