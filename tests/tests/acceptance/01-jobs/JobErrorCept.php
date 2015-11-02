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
$I->wantTo('ensure that job errors are visible');

$I->amGoingTo('try to login as admin');
$loginPage = LoginPage::openBy($I);
$loginPage->login('admin', 'admin');

$I->amGoingTo('enqueue a job');
$I->amOnPage('/resque/import');
#$I->makeScreenshot(basename(__FILE__).'-import');

$I->fillField('#widget-payload-jsoneditor TEXTAREA','{"command":"sleep 1 && exit 1"}');
$I->click('Submit');
$I->wait(1);
$I->see('created.', '.alert');
$I->makeScreenshot(basename(__FILE__).'-enqueued');

$I->wait(5);
$I->amOnPage('/resque');
$I->see('Job failed.','.alert-warning');
$I->makeScreenshot(basename(__FILE__).'-completed');