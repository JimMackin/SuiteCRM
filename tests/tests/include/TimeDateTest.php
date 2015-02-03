<?php
/**
 *
 *
 * @package
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author Salesagility Ltd <support@salesagility.com>
 */

class TimeDateTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $timedate = new TimeDate();
        $this->assertAttributeEquals(null,'user', $timedate);
    }

    public function testGetInstance()
    {
        $timedate = TimeDate::getInstance();

        $this->assertInstanceOf('TimeDate',$timedate);
        $this->assertAttributeEquals(null,'user', $timedate);

        $secondTimedate = TimeDate::getInstance();
        $this->assertEquals($timedate,$secondTimedate);
    }

    public function testAlwaysDb()
    {
        $timedate = new TimeDate();

        $this->assertEquals(false, $timedate->isAlwaysDb());

        $GLOBALS['disable_date_format'] = true;
        $this->assertEquals(true, $timedate->isAlwaysDb());
        $GLOBALS['disable_date_format'] = false;

        $timedate->setAlwaysDb(true);
        $this->assertEquals(true, $timedate->isAlwaysDb());
    }




    public function testSetUser()
    {
        $timedate = new TimeDate();

        $this->assertAttributeEquals(null,'user', $timedate);

        $timedate->setUser();
        $this->assertAttributeEquals(null,'user', $timedate);

        $user = $this->getMock('User');
        $timedate->setUser($user);
        $this->assertAttributeEquals($user,'user', $timedate);
    }


    public function testget_date_format()
    {

        $timedate = new TimeDate();

        $this->assertEquals(false, $timedate->isAlwaysDb());
        $user = $this->getMock('User');
        $user->method('getPreference')
            ->will($this->returnValue('d-m-Y'));
        $this->assertEquals('m/d/Y',$timedate->get_date_format());
        $this->assertEquals('d-m-Y',$timedate->get_date_format($user));

        $timedate->setAlwaysDb(true);
        $this->assertEquals('Y-m-d',$timedate->get_date_format());
        $this->assertEquals('Y-m-d',$timedate->get_date_format($user));

    }

    public function testget_time_format()
    {
        $timedate = new TimeDate();
        $this->assertEquals(false, $timedate->isAlwaysDb());
        $user = $this->getMock('User');
        $user->method('getPreference')
            ->will($this->returnValue('H i s'));
        $this->assertEquals('H:i',$timedate->get_time_format());
        $this->assertEquals('H i s',$timedate->get_time_format($user));

        $timedate->setAlwaysDb(true);
        $this->assertEquals('H:i:s',$timedate->get_time_format());
        $this->assertEquals('H:i:s',$timedate->get_time_format($user));
    }

    public function testget_date_time_format()
    {
        $timedate = new TimeDate();
        $this->assertEquals(false, $timedate->isAlwaysDb());

        $map = array(
            array('datef','global','d-m-Y'),
            array('timef','global', 'H i s')
        );
        $user = $this->getMock('User');

        $user->method('getPreference')
            ->will($this->returnValueMap($map));


        $this->assertEquals('m/d/Y H:i',$timedate->get_date_time_format());
        //FIXME: Need to find someway to mock SugarCache for all tests
        sugar_cache_reset_full();

        $this->assertEquals('d-m-Y H i s',$timedate->get_date_time_format($user));

        $timedate->setAlwaysDb(true);
        $this->assertEquals('Y-m-d H:i:s',$timedate->get_date_time_format());
        $this->assertEquals('Y-m-d H:i:s',$timedate->get_date_time_format($user));
    }


    public function testget_date_time_format_cache_key()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function get_first_day_of_week()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testmerge_date_time()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testsplit_date_time()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_cal_date_format()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_cal_time_format()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_cal_date_time_format()
    {
        $this->markTestIncomplete('Not implemented yet');
    }


    public function testcheck_matching_format()
    {
        $this->markTestIncomplete('Not implemented yet');

    }


    public function testasDb()
    {
        $this->markTestIncomplete('Not implemented yet');
    }


    public function testasDbType()
    {
        $this->markTestIncomplete('Not implemented yet');
    }


    public function testasUser()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testasUserType()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testasUserTs()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testasDbDate()
    {
        $this->markTestIncomplete('Not implemented yet');
    }


    public function testasUserDate()
    {
        $this->markTestIncomplete('Not implemented yet');
    }


    public function testasDbTime()
    {
        $this->markTestIncomplete('Not implemented yet');
    }


    public function testasUserTime()
    {
        $this->markTestIncomplete('Not implemented yet');
    }


    public function testfromDb()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testfromDbType()
    {
        $this->markTestIncomplete('Not implemented yet');

    }


    public function testfromDbDate()
    {
        $this->markTestIncomplete('Not implemented yet');
    }


    public function testfromDbFormat()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testfromUser()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testfromUserType()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testfromUserTime()
    {
        $this->markTestIncomplete('Not implemented yet');
    }


    public function testfromUserDate()
    {
        $this->markTestIncomplete('Not implemented yet');

    }


    public function testfromString()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testfromTimestamp()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testtzGMT()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testtzUser()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testto_display_date_time()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testto_display_time()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testsplitTime()
    {
        $this->markTestIncomplete('Not implemented yet');
    }


    public function testto_display_date()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testto_display()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_db_date_time_format()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_db_date_format()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_db_time_format()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testto_db()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testto_db_date()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testto_db_time()
    {
        $this->markTestIncomplete('Not implemented yet');

    }


    public function testto_db_date_time()
    {
        $this->markTestIncomplete('Not implemented yet');

    }

    public function testnowDb()
    {
        $this->markTestIncomplete('Not implemented yet');

    }

    public function testnowDbDate()
    {
        $this->markTestIncomplete('Not implemented yet');

    }

    public function testgetNow()
    {
        $this->markTestIncomplete('Not implemented yet');

    }

    public function testsetNow()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testnow()
    {
        $this->markTestIncomplete('Not implemented yet');
    }


    public function testnowDate()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testtimeSeparator()
    {
        $this->markTestIncomplete('Not implemented yet');

    }

    public function testtimeSeparatorFormat()
    {
        $this->markTestIncomplete('Not implemented yet');
    }


    public function testgetDayStartEndGMT()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testexpandDate()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testexpandTime()
    {
        $this->markTestIncomplete('Not implemented yet');

    }

    public function testget_default_midnight()
    {
        $this->markTestIncomplete('Not implemented yet');
    }


    public function testuserTimezone()
    {
        $this->markTestIncomplete('Not implemented yet');

    }

    public function testguessTimezone()
    {
        $this->markTestIncomplete('Not implemented yet');

    }

    public function testuserTimezoneSuffix()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testtzName()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function test_sortTz()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgetTimezoneList()
    {
        $this->markTestIncomplete('Not implemented yet');
    }


    public function testhttpTime()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testfromTimeArray()
    {
        $this->markTestIncomplete('Not implemented yet');
    }


    public function testgetDatePart()
    {
        $this->markTestIncomplete('Not implemented yet');

    }


    public function testgetTimePart()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgetUserUTCOffset()
    {
        $this->markTestIncomplete('Not implemented yet');
    }


    public function testget_regular_expression()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testparseDateRange()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testmerge_time_meridiem()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testswap_formats()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testhandle_offset()
    {
        $this->markTestIncomplete('Not implemented yet');

    }

    public function testget_gmt_db_datetime()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_gmt_db_date()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testhandleOffsetMax()
    {
        $this->markTestIncomplete('Not implemented yet');

    }

    public function testadjustmentForUserTimeZone()
    {
        $this->markTestIncomplete('Not implemented yet');

    }

    public function testconvert_to_gmt_datetime()
    {
        $this->markTestIncomplete('Not implemented yet');

    }

    public function testgetUserTimeZone()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testgetDSTRange()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_javascript_validation()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testAMPMMenu()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_user_date_format()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testget_user_time_format()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

}
