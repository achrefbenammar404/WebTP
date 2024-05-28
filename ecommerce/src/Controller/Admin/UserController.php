 namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/users")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="admin_user_list")
     */
    public function list(EntityManagerInterface $entityManager)
    {
        $users = $entityManager->getRepository(User::class)->findAll();

        return $this->render('admin/user/list.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_user_detail")
     */
    public function detail($id, EntityManagerInterface $entityManager)
    {
        $user = $entityManager->getRepository(User::class)->find($id);

        return $this->render('admin/user/detail.html.twig', [
            'user' => $user,
        ]);
    }
}
