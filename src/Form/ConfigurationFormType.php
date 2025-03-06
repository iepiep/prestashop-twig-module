
<?php
/**
 * @author Roberto Minini <r.minini@solution61.fr>
 * @copyright 2025 Roberto Minini
 * @license MIT
 */

namespace DimSymfony\Form;

use PrestaShopBundle\Form\Admin\Type\TranslatableType;
use PrestaShopBundle\Form\Admin\Type\SwitchType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class ConfigurationFormType extends AbstractType
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('DIM_SYMFONY_TEXT_TYPE', TranslatableType::class, [
                'label' => $this->translator->trans('Welcome Message', [], 'Modules.Dimsymfony.Admin'),
                'help' => $this->translator->trans('This message will be displayed on the front office page.', [], 'Modules.Dimsymfony.Admin'),
                'type' => TextType::class,
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 5, 'max' => 255]),
                ],
            ])
            ->add('DIMSYMFONY_ENABLE_MAPS', SwitchType::class, [
                'label' => $this->translator->trans('Enable Google Maps', [], 'Modules.Dimsymfony.Admin'),
                'help' => $this->translator->trans('Display Google Maps in the back office for appointments.', [], 'Modules.Dimsymfony.Admin'),
            ])
            ->add('DIMSYMFONY_GOOGLE_API_KEY', TextType::class, [
                'label' => $this->translator->trans('Google Maps API Key', [], 'Modules.Dimsymfony.Admin'),
                'help' => $this->translator->trans('Enter your Google Maps API key for routing functionality.', [], 'Modules.Dimsymfony.Admin'),
                'constraints' => [
                    new Length(['min' => 10, 'max' => 255]),
                    new Regex([
                        'pattern' => '/^[A-Za-z0-9_-]+$/',
                        'message' => 'The API key should only contain letters, numbers, underscores, and hyphens.',
                    ]),
                ],
                'required' => false,
            ]);
    }
}
