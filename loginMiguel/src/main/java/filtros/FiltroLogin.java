package filtros;

import java.io.IOException;
import javax.servlet.Filter;
import javax.servlet.FilterChain;
import javax.servlet.FilterConfig;
import javax.servlet.ServletException;
import javax.servlet.ServletRequest;
import javax.servlet.ServletResponse;
import javax.servlet.annotation.WebFilter;
import javax.servlet.http.HttpServletRequest;

/**
 *
 * @author Miguel Palomares
 */
@WebFilter(filterName = "FiltroLogin", urlPatterns = {"/alumnos","/asignaturas","/notas", "/unLogin"})
public class FiltroLogin implements Filter {

    private void doBeforeProcessing(ServletRequest request, ServletResponse response)
      throws IOException, ServletException {
    }

    private void doAfterProcessing(ServletRequest request, ServletResponse response)
      throws IOException, ServletException {
        
    }

    /**
     *
     * @param request The servlet request we are processing
     * @param response The servlet response we are creating
     * @param chain The filter chain we are processing
     *
     * @exception IOException if an input/output error occurs
     * @exception ServletException if a servlet error occurs
     */
    @Override
    public void doFilter(ServletRequest request, ServletResponse response,
      FilterChain chain)
      throws IOException, ServletException {

        doBeforeProcessing(request, response);

        try {
            if (((HttpServletRequest)request).getSession().getAttribute("LOGIN") != null) {
                chain.doFilter(request, response);
            } else {
                request.getRequestDispatcher("index.jsp").forward(request, response);
               
            }
        } catch (IOException | ServletException t) {
            System.out.println("Error en el filtro de acceso al usuario");
        }

        doAfterProcessing(request, response);
    }

    /**
     * Destroy method for this filter
     */
    public void destroy() {
    }

    /**
     * Init method for this filter
     */
    public void init(FilterConfig filterConfig) {
       
    }


    


}
