<?php
declare(strict_types=1);

namespace IdnkSoft\Back\IdnkpCarousel\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use IdnkSoft\Back\IdnkpCarousel\Entity\Carousel;
use IdnkSoft\Back\IdnkpCarousel\Grid\CarouselGridDefinitionFactory;
use IdnkSoft\Back\IdnkpCarousel\Grid\CarouselFilters;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Service\Grid\ResponseBuilder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PrestaShopBundle\Security\Annotation\AdminSecurity;
use PrestaShopBundle\Security\Annotation\ModuleActivated;

/**
 * Class AdminCarouselController.
 *
 * @ModuleActivated(moduleName="idnkpcarouselsanywhere", redirectRoute="idnkpcarousel_carousel_index")
 */
class AdminCarouselController extends FrameworkBundleAdminController
{
    /**
     * List carousels
     *
     * @AdminSecurity("is_granted('read', request.get('_legacy_controller'))", message="Access denied.")
     *
     * @param CarouselFilters $filters
     *
     * @return Response
     */
    public function indexAction(CarouselFilters $filters)
    {
        $carouselGridFactory = $this->get('idnksoft.idnkpcarousel.grid.factory.carousel');
        $carouselGrid = $carouselGridFactory->getGrid($filters);
        return $this->render(
            '@Modules/idnkpcarouselsanywhere/views/templates/admin/index.html.twig',
            [
                'enableSidebar' => true,
                'layoutTitle' => $this->trans('Carousel', 'Modules.Idnkpcarousel.Admin'),
                'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
                'carouselGrid' => $this->presentGrid($carouselGrid),
            ]
        );
    }

    /**
     * Provides filters functionality.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function searchAction(Request $request)
    {
        /** @var ResponseBuilder $responseBuilder */
        $responseBuilder = $this->get('prestashop.bundle.grid.response_builder');
        return $responseBuilder->buildSearchResponse(
            $this->get('idnksoft.idnkpcarousel.grid.definition.factory.carousel'),
            $request,
            CarouselGridDefinitionFactory::GRID_ID,
            'idnkpcarousel_carousel_index'
        );
    }

    /**
     * Create carousel
     *
     * @AdminSecurity("is_granted('read', request.get('_legacy_controller'))", message="Access denied.")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function createAction(Request $request)
    {
        $carouselFormBuilder = $this->get(
            'idnksoft.idnkpcarousel.form.builder.carousel'
        );
        $carouselForm = $carouselFormBuilder->getForm();
        $carouselForm->handleRequest($request);
        $carouselFormHandler = $this->get(
            'idnksoft.idnkpcarousel.form.handler.carousel'
        );
        $result = $carouselFormHandler->handle($carouselForm);
        if (null !== $result->getIdentifiableObjectId()) {
            $this->addFlash(
                'success',
                $this->trans('Successful creation.', 'Admin.Notifications.Success')
            );
            return $this->redirectToRoute('idnkpcarousel_carousel_index');
        }
        return $this->render(
            '@Modules/idnkpcarouselsanywhere/views/templates/admin/create.html.twig',
            [
                'layoutTitle' => $this->trans('Create carousel', 'Modules.Idnkpcarousel.Admin'),
                'carouselForm' => $carouselForm->createView(),
            ]
        );
    }

    /**
     * Edit carousel
     * @AdminSecurity("is_granted('read', request.get('_legacy_controller'))", message="Access denied.")
     *
     * @param Request $request
     * @param int $carouselId
     *
     * @return Response
     */
    public function editAction(Request $request, $carouselId)
    {
        $carouselFormBuilder = $this->get(
            'idnksoft.idnkpcarousel.form.builder.carousel'
        );
        $carouselForm = $carouselFormBuilder->getFormFor((int)$carouselId);
        $carouselForm->handleRequest($request);
        $carouselFormHandler = $this->get(
            'idnksoft.idnkpcarousel.form.handler.carousel'
        );
        $result = $carouselFormHandler->handleFor((int)$carouselId, $carouselForm);
        if ($result->isSubmitted() && $result->isValid()) {
            $this->addFlash(
                'success',
                $this->trans(
                    'Successful update.',
                    'Admin.Notifications.Success'
                )
            );
            return $this->redirectToRoute('idnkpcarousel_carousel_index');
        }
        return $this->render(
            '@Modules/idnkpcarouselsanywhere/views/templates/admin/edit.html.twig',
            [
                'carouselForm' => $carouselForm->createView(),
                'layoutTitle' => $this->trans('Carousel edition', 'Modules.Idnkpcarousel.Admin'),
                'help_link' => false,
            ]
        );
    }

    /**
     * Delete carousel
     * @AdminSecurity("is_granted('read', request.get('_legacy_controller'))", message="Access denied.")
     *
     * @param int $carouselId
     *
     * @return Response
     */
    public function deleteAction($carouselId)
    {
        $repository = $this->get(
            'idnksoft.idnkpcarousel.repository.carousel'
        );
        try {
            $carousel = $repository->findOneById($carouselId);
        } catch (EntityNotFoundException $e) {
            $carousel = null;
        }
        if (null !== $carousel) {
            /** @var EntityManagerInterface $em */
            $em = $this->get('doctrine.orm.entity_manager');
            $em->remove($carousel);
            $em->flush();
            $repository->removeCarouselCategories((int)$carouselId);
            $this->addFlash(
                'success',
                $this->trans(
                    'Successful deletion.',
                    'Admin.Notifications.Success'
                )
            );
        } else {
            $this->addFlash(
                'error',
                $this->trans(
                    'Cannot find carousel %carousel%',
                    'Modules.Idnkpcarousel.Admin',
                    ['%quote%' => $carouselId]
                )
            );
        }
        return $this->redirectToRoute('idnkpcarousel_carousel_index');
    }

    /**
     * Delete bulk quotes
     * @AdminSecurity("is_granted('read', request.get('_legacy_controller'))", message="Access denied.")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function deleteBulkAction(Request $request)
    {
        $carouselIds = $request->request->get('carousel_bulk');
        $repository = $this->get(
            'idnksoft.idnkpcarousel.repository.carousel'
        );
        try {
            $carousels = $repository->findById($carouselIds);
        } catch (EntityNotFoundException $e) {
            $carousels = null;
        }
        if (!empty($carousels)) {
            /** @var EntityManagerInterface $em */
            $em = $this->get('doctrine.orm.entity_manager');
            foreach ($carousels as $carousel) {
                $em->remove($carousel);
                $repository->removeCarouselCategories($carousel->getId());
            }
            $em->flush();
            $this->addFlash(
                'success',
                $this->trans(
                    'The selection has been successfully deleted.',
                    'Admin.Notifications.Success'
                )
            );
        }
        return $this->redirectToRoute('idnkpcarousel_carousel_index');
    }

    /**
     * @return array[]
     */
    private function getToolbarButtons()
    {
        return [
            'add' => [
                'desc' => $this->trans(
                    'Add new carousel',
                    'Modules.Idnkpcarousel.Admin'
                ),
                'icon' => 'add_circle_outline',
                'href' => $this->generateUrl('idnkpcarousel_carousel_create'),
            ]
        ];
    }

    /**
     * @param Request $request
     * @param int $carouselId
     *
     * @return Response
     */
    public function toggleAction(Request $request, int $carouselId): Response
    {
        $entityManager = $this->get('doctrine.orm.entity_manager');
        $contentBlock = $entityManager
            ->getRepository(Carousel::class)
            ->findOneBy(['id' => $carouselId]);

        if (empty($contentBlock)) {
            return $this->json([
                'status' => false,
                'message' => sprintf('Content block %d doesn\'t exist', $carouselId)
            ]);
        }

        try {
            $contentBlock->setActive(!$contentBlock->isActive());
            $entityManager->flush();
            $response = [
                'status' => true,
                'message' => $this->trans('The status has been successfully updated.', 'Admin.Notifications.Success'),
            ];
        } catch (\Exception $e) {
            $response = [
                'status' => false,
                'message' => sprintf(
                    'There was an error while updating the status of content block %d: %s',
                    $carouselId,
                    $e->getMessage()
                ),
            ];
        }

        return $this->json($response);
    }
}