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
$I->wantTo('ensure that hrzg/resque jobs queue works');

$I->amGoingTo('try to login as admin');
$loginPage = LoginPage::openBy($I);
$loginPage->login('admin', 'admin');

$I->amGoingTo('enqueue a job');
$I->amOnPage('/resque/import');
#$I->makeScreenshot(basename(__FILE__).'-import');

$I->fillField('#widget-payload-jsoneditor TEXTAREA','{"command":"sleep 1 && ls -la"}');
#$I->click('Submit');
#$I->wait(1);
#$I->submitForm('.form FORM');

$I->see('created.', '.alert');
$I->makeScreenshot(basename(__FILE__).'-enqueued');

$I->wait(5);
$I->amOnPage('/resque');
$I->see('Job completed successfully.', '.alert');
$I->makeScreenshot(basename(__FILE__).'-completed');