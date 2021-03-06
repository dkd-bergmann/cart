<?php

namespace Extcode\Cart\Tests\Domain\Model\Cart;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Daniel Lorenz <ext.cart@extco.de>, extco.de
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Variant Test
 *
 * @author Daniel Lorenz
 * @license http://www.gnu.org/licenses/lgpl.html
 *                     GNU Lesser General Public License, version 3 or later
 */
class BeVariantTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Extcode\Cart\Domain\Model\Cart\TaxClass
     */
    protected $taxClass = null;

    /**
     * @var \Extcode\Cart\Domain\Model\Cart\Product
     */
    protected $product = null;

    /**
     * @var \Extcode\Cart\Domain\Model\Cart\BeVariant
     */
    protected $beVariant = null;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $sku;

    /**
     * @var int
     */
    protected $priceCalcMethod;

    /**
     * @var float
     */
    protected $price;

    /**
     * @var int
     */
    protected $quantity;

    /**
     * Set Up
     */
    public function setUp()
    {
        $this->taxClass = new \Extcode\Cart\Domain\Model\Cart\TaxClass(1, '19', 0.19, 'normal');

        $this->product = $this->getMock(
            \Extcode\Cart\Domain\Model\Cart\Product::class,
            [],
            [],
            '',
            false
        );
        $this->product->expects($this->any())->method('getTaxClass')->will($this->returnValue($this->taxClass));
        $this->product->expects($this->any())->method('getTitle')->will($this->returnValue('Test Product'));
        $this->product->expects($this->any())->method('getSku')->will($this->returnValue('test-product'));

        $this->id = '1';
        $this->title = 'Test Variant';
        $this->sku = 'test-variant-sku';
        $this->priceCalcMethod = 0;
        $this->price = 1.00;
        $this->quantity = 1;

        $this->beVariant = new \Extcode\Cart\Domain\Model\Cart\BeVariant(
            $this->id,
            $this->product,
            null,
            $this->title,
            $this->sku,
            $this->priceCalcMethod,
            $this->price,
            $this->quantity
        );
    }

    /**
     * @test
     */
    public function getIdReturnsIdSetByConstructor()
    {
        $this->assertSame(
            $this->id,
            $this->beVariant->getId()
        );
    }

    /**
     * @test
     */
    public function getSkuReturnsSkuSetByConstructor()
    {
        $this->assertSame(
            $this->sku,
            $this->beVariant->getSku()
        );
    }

    /**
     * @test
     */
    public function getCompleteSkuReturnsCompleteSkuSetByConstructor()
    {
        $sku = $this->product->getSku() . '-' . $this->sku;
        $this->assertSame(
            $sku,
            $this->beVariant->getCompleteSku()
        );
    }

    /**
     * @test
     */
    public function getSkuWithSkuDelimiterReturnsSkuSetByConstructorWithGivenSkuDelimiter()
    {
        $skuDelimiter = '_';
        $this->beVariant->setSkuDelimiter($skuDelimiter);

        $sku = $this->product->getSku() . $skuDelimiter . $this->sku;
        $this->assertSame(
            $sku,
            $this->beVariant->getCompleteSku()
        );
    }

    /**
     * @test
     */
    public function getTitleReturnsTitleSetByConstructor()
    {
        $this->assertSame(
            $this->title,
            $this->beVariant->getTitle()
        );
    }

    /**
     * @test
     */
    public function getCompleteTitleReturnsCompleteTitleSetByConstructor()
    {
        $title = $this->product->getTitle() . ' - ' . $this->title;
        $this->assertSame(
            $title,
            $this->beVariant->getCompleteTitle()
        );
    }

    /**
     * @test
     */
    public function getTitleWithTitleDelimiterReturnsTitleSetByConstructorWithGivenTitleDelimiter()
    {
        $titleDelimiter = ',';
        $this->beVariant->setTitleDelimiter($titleDelimiter);

        $title = $this->product->getTitle() . $titleDelimiter . $this->title;
        $this->assertSame(
            $title,
            $this->beVariant->getCompleteTitle()
        );
    }

    /**
     * @test
     */
    public function getPriceReturnsPriceSetByConstructor()
    {
        $this->assertSame(
            $this->price,
            $this->beVariant->getPrice()
        );
    }

    /**
     * @test
     */
    public function getPriceCalcMethodReturnsPriceCalcSetByConstructor()
    {
        $this->assertSame(
            $this->priceCalcMethod,
            $this->beVariant->getPriceCalcMethod()
        );
    }

    /**
     * @test
     */
    public function getQuantityReturnsQuantitySetByConstructor()
    {
        $this->assertSame(
            $this->quantity,
            $this->beVariant->getQuantity()
        );
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function constructVariantWithoutCartProductOrVariantThrowsInvalidArgumentException()
    {
        new \Extcode\Cart\Domain\Model\Cart\BeVariant(
            $this->id,
            null,
            null,
            $this->sku,
            $this->title,
            $this->priceCalcMethod,
            $this->price,
            $this->quantity
        );
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function constructVariantWithCartProductAndVariantThrowsInvalidArgumentException()
    {
        $cartProduct = $this->getMock('Extcode\\Cart\\Domain\\Model\\Cart\\Product', [], [], '', false);
        $cartProduct->expects($this->any())->method('getTaxClass')->will($this->returnValue($this->taxClass));
        $variant = $this->getMock('Extcode\\Cart\\Domain\\Model\\Cart\\BeVariant', [], [], '', false);
        $variant->expects($this->any())->method('getTaxClass')->will($this->returnValue($this->taxClass));

        new \Extcode\Cart\Domain\Model\Cart\BeVariant(
            $this->id,
            $cartProduct,
            $variant,
            $this->sku,
            $this->title,
            $this->priceCalcMethod,
            $this->price,
            $this->quantity
        );
    }

    /**
     * @test
     */
    public function constructWithoutTitleThrowsException()
    {
        $cartProduct = $this->getMock('Extcode\\Cart\\Domain\\Model\\Cart\\Product', [], [], '', false);
        $cartProduct->expects($this->any())->method('getTaxClass')->will($this->returnValue($this->taxClass));

        $this->setExpectedException(
            'InvalidArgumentException',
            'You have to specify a valid $title for constructor.',
            1437166475
        );

        new \Extcode\Cart\Domain\Model\Cart\BeVariant(
            1,
            $cartProduct,
            null,
            null,
            'test-variant-sku',
            0,
            1.0,
            1
        );
    }

    /**
     * @test
     */
    public function constructWithoutSkuThrowsException()
    {
        $cartProduct = $this->getMock('Extcode\\Cart\\Domain\\Model\\Cart\\Product', [], [], '', false);
        $cartProduct->expects($this->any())->method('getTaxClass')->will($this->returnValue($this->taxClass));

        $this->setExpectedException(
            'InvalidArgumentException',
            'You have to specify a valid $sku for constructor.',
            1437166615
        );

        new \Extcode\Cart\Domain\Model\Cart\BeVariant(
            1,
            $cartProduct,
            null,
            'Test Variant',
            null,
            0,
            1.0,
            1
        );
    }

    /**
     * @test
     */
    public function constructWithoutQuantityThrowsException()
    {
        $cartProduct = $this->getMock('Extcode\\Cart\\Domain\\Model\\Cart\\Product', [], [], '', false);
        $cartProduct->expects($this->any())->method('getTaxClass')->will($this->returnValue($this->taxClass));

        $this->setExpectedException(
            'InvalidArgumentException',
            'You have to specify a valid $quantity for constructor.',
            1437166805
        );

        new \Extcode\Cart\Domain\Model\Cart\BeVariant(
            1,
            $cartProduct,
            null,
            'Test Variant',
            'test-variant-sku',
            0,
            1.0,
            null
        );
    }

    /**
     * @test
     */
    public function getMinReturnsInitialValueMin()
    {
        $this->assertSame(
            0,
            $this->beVariant->getMin()
        );
    }

    /**
     * @test
     */
    public function setMinIfMinIsEqualToMax()
    {
        $min = 1;
        $max = 1;

        $this->beVariant->setMax($max);
        $this->beVariant->setMin($min);

        $this->assertEquals(
            $min,
            $this->beVariant->getMin()
        );
    }

    /**
     * @test
     */
    public function setMinIfMinIsLesserThanMax()
    {
        $min = 1;
        $max = 2;

        $this->beVariant->setMax($max);
        $this->beVariant->setMin($min);

        $this->assertEquals(
            $min,
            $this->beVariant->getMin()
        );
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function throwsInvalidArgumentExceptionIfMinIsGreaterThanMax()
    {
        $min = 2;
        $max = 1;

        $this->beVariant->setMax($max);
        $this->beVariant->setMin($min);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function throwsInvalidArgumentExceptionIfMinIsNegativ()
    {
        $min = -1;
        $max = 1;

        $this->beVariant->setMax($max);
        $this->beVariant->setMin($min);
    }

    /**
     * @test
     */
    public function getMaxReturnsInitialValueMax()
    {
        $this->assertSame(
            0,
            $this->beVariant->getMax()
        );
    }

    /**
     * @test
     */
    public function setMaxIfMaxIsEqualToMin()
    {
        $min = 1;
        $max = 1;

        //sets max before because $min and $max are 0 by default
        $this->beVariant->setMax($max);
        $this->beVariant->setMin($min);

        $this->beVariant->setMax($max);

        $this->assertEquals(
            $max,
            $this->beVariant->getMax()
        );
    }

    /**
     * @test
     */
    public function setMaxIfMaxIsGreaterThanMin()
    {
        $min = 1;
        $max = 2;

        //sets max before because $min and $max are 0 by default
        $this->beVariant->setMax($min);
        $this->beVariant->setMin($min);

        $this->beVariant->setMax($max);

        $this->assertEquals(
            $max,
            $this->beVariant->getMax()
        );
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function throwsInvalidArgumentExceptionIfMaxIsLesserThanMin()
    {
        $min = 2;
        $max = 1;

        //sets max before because $min and $max are 0 by default
        $this->beVariant->setMax($min);
        $this->beVariant->setMin($min);

        $this->beVariant->setMax($max);
    }
}
