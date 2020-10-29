<?php

/*
 * This file is part of the Single Color Petrinet framework.
 *
 * (c) Tien Vo Xuan <tien.xuan.vo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SingleColorPetrinet\Model;

use Petrinet\Model\Marking as BaseMarking;

/**
 * Implementation of MarkingInterface.
 *
 * @author Tien Vo Xuan <tien.xuan.vo@gmail.com>
 */
class ColorfulMarking extends BaseMarking implements ColorfulMarkingInterface
{
    /**
     * {@inheritdoc}
     */
    public function getColor(): ?ColorInterface
    {
        foreach ($this->placeMarkings as $placeMarking) {
            foreach ($placeMarking->getTokens() as $token) {
                if ($token instanceof ColorfulTokenInterface) {
                    return $token->getColor();
                }
            }
        }

        return null;
    }
}
