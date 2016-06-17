<?php

namespace Martin1982\LiveBroadcastBundle\Admin;

use Martin1982\LiveBroadcastBundle\Entity\Channel\ChannelFacebook;
use Martin1982\LiveBroadcastBundle\Entity\Channel\ChannelTwitch;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class ChannelAdmin
 * @package Martin1982\LiveBroadcastBundle\Admin
 */
class ChannelAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'channel';

    /**
     * @param string $name
     * @return mixed|null|string
     */
    public function getTemplate($name)
    {
        $subject = $this->getSubject();

        if ($subject instanceof ChannelFacebook && $name === 'edit') {
            return 'LiveBroadcastBundle:CRUD:channel_facebook_edit.html.twig';
        }

        return parent::getTemplate($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $subject = $this->getSubject();

        $formMapper
            ->with('Channel')
                ->add('channelName', 'text', array('label' => 'Channel name'));

        if ($subject instanceof ChannelTwitch) {
            $formMapper->add('streamKey', 'text', array('label' => 'Twitch stream key'));
            $formMapper->add('streamServer', 'text', array('label' => 'Twitch stream server'));
        }

        if ($subject instanceof ChannelFacebook) {
            $formMapper->add('accessToken', 'text', array('label' => 'Facebook access token'));
            $formMapper->add('fbEntityId', 'text', array('label' => 'Facebook entity ID'));
            $formMapper->add('applicationId', 'text', array('label' => 'Facebook app ID'));
            $formMapper->add('applicationSecret', 'text', array('label' => 'Facebook app secret'));
        }

        $formMapper->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('channelName');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('channelName')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                    'delete' => array(),
                ),
            ));
    }
}
