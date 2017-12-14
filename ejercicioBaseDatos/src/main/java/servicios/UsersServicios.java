/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package servicios;

import config.Configuration;
import dao.UsersDAO;
import java.security.NoSuchAlgorithmException;
import java.security.spec.InvalidKeySpecException;
import java.time.LocalDateTime;
import java.util.logging.Level;
import java.util.logging.Logger;
import model.User;
import utils.Constantes;
import utils.PasswordHash;
import utils.Utils;

/**
 *
 * @author Miguel Angel Diaz
 */
public class UsersServicios {

    public User registrar(User user) {
        UsersDAO dao = new UsersDAO();

        boolean existe = this.comprobarNombres(user.getNombre());

        User alta = null;
        if (!existe) {
            try {
                user.setPassword(PasswordHash.getInstance().createHash(user.getPassword()));
                user.setCodigo_activacion(Utils.randomAlphaNumeric(Configuration.getInstance().getLongitudCodigo()));
                LocalDateTime fechaActual = LocalDateTime.now();
                user.setFecha_activacion(fechaActual);
                alta = dao.registrar(user);
                MailServicios mail = new MailServicios();
                mail.mandarMail(user.getEmail(), Constantes.LINK_EMAIL + user.getCodigo_activacion(), Constantes.ASUNTO_EMAIL);
            } catch (NoSuchAlgorithmException | InvalidKeySpecException ex) {
                Logger.getLogger(UsersServicios.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
        return alta;
    }

    public boolean comprobarNombres(String nombreUser) {
        UsersDAO dao = new UsersDAO();
        return dao.comprobarNombres(nombreUser);
    }

    public boolean login(User user) {
        boolean valido = false;
        try {

            UsersDAO dao = new UsersDAO();
            User userDB = dao.getUserByNombre(user.getNombre());
            boolean passCorrecta = PasswordHash.getInstance().validatePassword(user.getPassword(), userDB.getPassword());
            if (passCorrecta == true && userDB.getActivo()) {
                valido = true;
            }

        } catch (NoSuchAlgorithmException | InvalidKeySpecException ex) {
            Logger.getLogger(UsersServicios.class.getName()).log(Level.SEVERE, null, ex);
        }
        return valido;
    }

    public int activar(String codigo) {
        UsersDAO dao = new UsersDAO();
        int activar;
        User userDB = dao.getUserByCodigoActivacion(codigo);

        if (!userDB.getActivo()) {
            LocalDateTime fechaActivacion = userDB.getFecha_activacion();
            LocalDateTime fechaActual = LocalDateTime.now().minusMinutes(Configuration.getInstance().getMinutosParaValidar());
            if (fechaActivacion.isAfter(fechaActual)) {
                activar = dao.updateValido(userDB);
            } else {
                dao.borrarUserByCodigoActivacion(userDB);
                activar = 0;
            }
        } else {
            activar = 2;
        }
        return activar;
    }

}
