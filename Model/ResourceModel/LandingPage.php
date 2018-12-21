<?php

namespace Algolia\AlgoliaSearch\Model\ResourceModel;

use Algolia\AlgoliaSearch\Api\Data\LandingPageInterface;
use Magento\Framework\DB\Select;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Store\Model\Store;

class LandingPage extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init(LandingPageInterface::TABLE_NAME, LandingPageInterface::FIELD_LANDING_PAGE_ID);
    }

    /**
     * Check if landing page identifier exist for specific store
     * return page id if page exists
     *
     * @param string $identifier
     * @param int $storeId
     * @return int
     */
    public function checkIdentifier($identifier, $storeId)
    {
        $select = $this->getConnection()
            ->select()
            ->from(['lp' => $this->getMainTable()])
            ->where('url_key = ?', $identifier)
            ->where('is_active = ?', 1)
            ->where('store_id IN (?)', [Store::DEFAULT_STORE_ID, $storeId])
            ->order('store_id DESC')
            ->limit(1);

        return $this->getConnection()->fetchOne($select);
    }
}
