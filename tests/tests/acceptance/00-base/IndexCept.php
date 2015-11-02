<?php
/**
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2015 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use tests\_support\LoginPage;

$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that hrzg/resque works');

$I->amGoingTo('check resque access rules');
$I->amOnPage('/resque');
$I->see('Sign In');
$I->makeScreenshot(basename(__FILE__).'-sign-in');

$I->amGoingTo('try to login as admin');
$loginPage = LoginPage::openBy($I);
$loginPage->login('admin', 'admin');

$I->amGoingTo('visit the resque importer');
$I->amOnPage('/resque/import');
$I->makeScreenshot(basename(__FILE__).'-import');