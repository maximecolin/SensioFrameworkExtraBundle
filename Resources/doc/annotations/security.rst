@Security
=========

Usage
-----

The ``@Security`` annotation restricts access on controllers::

    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

    class PostController extends Controller
    {
        /**
         * @Security("has_role('ROLE_ADMIN')")
         */
        public function indexAction()
        {
            // ...
        }
    }

The expression can use all functions that you can use in the
``access_control`` section of the security bundle configuration, and it also
has access to the current ``request`` object.

.. note::

    Defining a ``Security`` annotation has the same effect as defining an
    access control rule, but it is more efficient as the check is only done
    when this specific route is accessed.

.. tip::

    You can also add a ``@Security`` annotation on a controller class.
