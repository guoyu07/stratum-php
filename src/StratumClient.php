<?php

namespace BitWasp\Bitcoin\Stratum;

use BitWasp\Bitcoin\Stratum\Connector\ConnectorInterface;
use BitWasp\Bitcoin\Stratum\Request\RequestFactory;

/*
 * Surely not a comprehensive list, derived from:
 *  - https://docs.google.com/document/d/17zHy1SUlhgtCMbypO8cHgpWH73V5iUQKk_0rWvMqSNs/edit?hl=en_US
 *  - https://electrum.orain.org/wiki/Stratum_protocol_specification
 */

class StratumClient
{
    /**
     * @var RequestFactory
     */
    private $reqFactory;

    /**
     * @var ConnectorInterface
     */
    private $connector;

    /**
     * @param \BitWasp\Bitcoin\Stratum\Connector\ConnectorInterface $connector
     * @param RequestFactory $reqFactory
     */
    public function __construct(ConnectorInterface $connector, RequestFactory $reqFactory)
    {
        $this->connector = $connector;
        $this->reqFactory = $reqFactory;
    }

    /**
     * @param string $txid
     * @return \React\Promise\Promise
     */
    public function getTransaction($txid)
    {
        return $this->connector->send($this->reqFactory->create('blockchain.transaction.get', [$txid]));
    }

    /**
     * @param string $clientVersion
     * @param string $protocolVersion
     * @return \React\Promise\Promise
     */
    public function sendVersion($clientVersion, $protocolVersion)
    {
        return $this->connector->send($this->reqFactory->create('server.version', [$clientVersion, $protocolVersion]));
    }

    /**
     * @return \React\Promise\Promise
     */
    public function getBanner()
    {
        return $this->connector->send($this->reqFactory->create('server.banner'));
    }

    /**
     * @param string $address
     * @return \React\Promise\Promise
     */
    public function getAddressHistory($address)
    {
        return $this->connector->send($this->reqFactory->create('blockchain.address.get_history', [$address]));
    }

    public function getMemPool()
    {
        // ??
    }

    /**
     * @param string $address
     * @return \React\Promise\Promise
     */
    public function getAddressBalance($address)
    {
        return $this->connector->send($this->reqFactory->create('blockchain.address.get_balance', [$address]));
    }

    /**
     * @param string $address
     * @return \React\Promise\Promise
     */
    public function getAddressUnspent($address)
    {
        return $this->connector->send($this->reqFactory->create('blockchain.address.get_balance', [$address]));
    }

    /**
     * @param string $txid
     * @param int $txHeight
     * @return \React\Promise\Promise
     */
    public function getTransactionMerkle($txid, $txHeight)
    {
        return $this->connector->send($this->reqFactory->create('blockchain.transaction.get_merkle', [$txid, $txHeight]));
    }
}
