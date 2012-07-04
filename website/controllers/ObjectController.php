<?php
/**
 * Created by elements.at New Media Solutions GmbH
 * Nikolaus Flamann
 * File: ObjectController.php
 * User: nflamann
 * Date: 04.07.12
 * Time: 17:51
 * @var $this Pimcore_View
 */


class ObjectController extends Website_Controller_Action
{
    public function init()
    {
        parent::init();

        $this->enableLayout();

    }

    public function listAction()
    {

        $objectlist = new Object_News_List();

        $cond = "   active = 1 AND
                    showfrom >= " . Website_Tool_Time::getStartDate()->getTimestamp() . " AND
                    showto  <=" . Website_Tool_Time::getEndDate()->getTimestamp();

       // $objectlist->setCondition($cond);

        /**
         * The Newest News to the first
         */
        $objectlist->setOrderKey("date");
        $objectlist->setOrder("DESC");


        /**
         * I like Paging
         */

        $paginator = Zend_Paginator::factory($objectlist);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setPageRange(5);
        $paginator->setItemCountPerPage(2);

        $this->view->paginator = $paginator;


    }
}
