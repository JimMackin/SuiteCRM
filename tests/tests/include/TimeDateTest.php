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
        $this->assertSame($timedate,$secondTimedate);
    }

    public function testAlwaysDb()
    {
        $timedate = new TimeDate();

        $this->assertSame(false, $timedate->isAlwaysDb());

        $GLOBALS['disable_date_format'] = true;
        $this->assertSame(true, $timedate->isAlwaysDb());
        $GLOBALS['disable_date_format'] = false;

        $timedate->setAlwaysDb(true);
        $this->assertSame(true, $timedate->isAlwaysDb());
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

        $this->assertSame(false, $timedate->isAlwaysDb());
        $user = $this->getMock('User');
        $user->method('getPreference')
            ->will($this->returnValue('d-m-Y'));
        $this->assertSame('m/d/Y',$timedate->get_date_format());
        $this->assertSame('d-m-Y',$timedate->get_date_format($user));

        $timedate->setAlwaysDb(true);
        $this->assertSame('Y-m-d',$timedate->get_date_format());
        $this->assertSame('Y-m-d',$timedate->get_date_format($user));

    }

    public function testget_time_format()
    {
        $timedate = new TimeDate();
        $this->assertSame(false, $timedate->isAlwaysDb());
        $user = $this->getMock('User');
        $user->method('getPreference')
            ->will($this->returnValue('H i s'));
        $this->assertSame('H:i',$timedate->get_time_format());
        $this->assertSame('H i s',$timedate->get_time_format($user));

        $timedate->setAlwaysDb(true);
        $this->assertSame('H:i:s',$timedate->get_time_format());
        $this->assertSame('H:i:s',$timedate->get_time_format($user));
    }

    public function testget_date_time_format()
    {
        $timedate = new TimeDate();
        $this->assertSame(false, $timedate->isAlwaysDb());

        $map = array(
            array('datef','global','d-m-Y'),
            array('timef','global', 'H i s')
        );
        $user = $this->getMock('User');

        $user->method('getPreference')
            ->will($this->returnValueMap($map));


        $this->assertSame('m/d/Y H:i',$timedate->get_date_time_format());
        //FIXME: Need to find someway to mock SugarCache for all tests
        sugar_cache_reset_full();

        $this->assertSame('d-m-Y H i s',$timedate->get_date_time_format($user));

        $timedate->setAlwaysDb(true);
        $this->assertSame('Y-m-d H:i:s',$timedate->get_date_time_format());
        $this->assertSame('Y-m-d H:i:s',$timedate->get_date_time_format($user));
    }


    public function testget_date_time_format_cache_key()
    {
        $timedate = new TimeDate();
        $this->assertSame(false, $timedate->isAlwaysDb());
        $user = $this->getMock('User');
        $user->id = '12345';
        $this->assertSame('TimeDatedateTimeFormat_12345',$timedate->get_date_time_format_cache_key($user));
        $timedate->setAlwaysDb(true);
        $this->assertSame('TimeDatedateTimeFormat_12345_asdb',$timedate->get_date_time_format_cache_key($user));

    }

    public function testget_first_day_of_week()
    {
        $timedate = new TimeDate();
        $this->assertSame(false, $timedate->isAlwaysDb());

        $this->assertSame(0,$timedate->get_first_day_of_week());

        $user = $this->getMock('User');
        $user->method('getPreference')
            ->will($this->returnValue(5));
        $this->assertSame(5,$timedate->get_first_day_of_week($user));

        $user->method('getPreference')
            ->will($this->returnValue(null));
        $this->assertSame(0,$timedate->get_first_day_of_week());
    }

    public function testmerge_date_time()
    {
        $timedate = new TimeDate();
        $this->assertSame('abc def',$timedate->merge_date_time('abc','def'));
        $this->assertSame('abc ',$timedate->merge_date_time('abc',null));
    }

    public function testsplit_date_time()
    {
        $timedate = new TimeDate();
        $this->assertSame(array('2014-01-03', '18:37:15'),$timedate->split_date_time('2014-01-03 18:37:15'));
        $this->assertSame(array('2014-01-03'),$timedate->split_date_time('2014-01-03'));
    }

    public function testget_cal_date_format()
    {
        //FIXME: Refactor to prevent reliance on Global user object
        $tmp = $GLOBALS['current_user'];
        $timedate = new TimeDate();
        $this->assertSame('%m/%d/%Y',$timedate->get_cal_date_format());
        $user = $this->getMock('User');
        $user->method('getPreference')
            ->will($this->returnValue('d-m-Y'));
        $GLOBALS['current_user'] = $user;
        $this->assertSame('%d-%m-%Y',$timedate->get_cal_date_format());
        $GLOBALS['current_user'] = $tmp;
        $timedate->setAlwaysDb(true);
        $this->assertSame('%Y-%m-%d',$timedate->get_cal_date_format());
    }

    public function testget_cal_time_format()
    {
        //FIXME: Refactor to prevent reliance on Global user object
        $tmp = $GLOBALS['current_user'];
        $timedate = new TimeDate();
        $this->assertSame('%H:%M',$timedate->get_cal_time_format());
        $user = $this->getMock('User');
        $user->method('getPreference')
            ->will($this->returnValue('H i s'));
        $GLOBALS['current_user'] = $user;
        $this->assertSame('%H %M %S',$timedate->get_cal_time_format());
        $GLOBALS['current_user'] = $tmp;
        $timedate->setAlwaysDb(true);
        $this->assertSame('%H:%M:%S',$timedate->get_cal_time_format());
    }

    public function testget_cal_date_time_format()
    {

        $map = array(
            array('datef','global','d-m-Y'),
            array('timef','global', 'H i s')
        );
        //FIXME: Refactor to prevent reliance on Global user object
        $tmp = $GLOBALS['current_user'];
        $timedate = new TimeDate();
        $this->assertSame('%m/%d/%Y %H:%M',$timedate->get_cal_date_time_format());
        $user = $this->getMock('User');
        $user->method('getPreference')
            ->will($this->returnValueMap($map));
        $GLOBALS['current_user'] = $user;
        $this->assertSame('%d-%m-%Y %H %M %S',$timedate->get_cal_date_time_format());
        $GLOBALS['current_user'] = $tmp;
        $timedate->setAlwaysDb(true);
        $this->assertSame('%Y-%m-%d %H:%M:%S',$timedate->get_cal_date_time_format());
    }


    public function check_matching_formatProvider()
    {
        return array(
            array('2014-01-12 13:11:01', 'Y-m-d H:i:s', true),
            array('2014-01-12 13:11:01', 'Y-m-d', false),
            array('2014-13-12 13:11:01', 'Y-m-d H:i:s', true),
            array('4/25/2012', 'm/d/Y', true),
            array('4-25-2012', 'm/d/Y', false),
        );
    }

    /**
     * @dataProvider check_matching_formatProvider
     */
    public function testcheck_matching_format($date, $format, $expected)
    {
        $timedate = new TimeDate();
        $this->assertSame($expected, $timedate->check_matching_format($date,$format));

    }

    public function asDbProvider()
    {
        $utc = new DateTimeZone('UTC');
        $gb = new DateTimeZone('Europe/London');
        return array(
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), '2015-02-15 15:16:17'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), '2015-09-01 00:02:03'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), '2015-02-15 15:16:17'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), '2015-08-31 23:02:03'),
        );
    }

    /**
     * @dataProvider asDbProvider
     */
    public function testasDb($datetime, $expected)
    {
        $timedate = new TimeDate();
        $this->assertSame($expected, $timedate->asDb($datetime));

    }

    public function asDbTypeProvider()
    {
        $utc = new DateTimeZone('UTC');
        $gb = new DateTimeZone('Europe/London');
        return array(
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), 'date', '2015-02-15'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), 'date', '2015-09-01'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), 'date', '2015-02-15'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), 'date', '2015-09-01'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), 'time', '15:16:17'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), 'time', '00:02:03'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), 'time', '15:16:17'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), 'time', '23:02:03'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), 'datetime', '2015-02-15 15:16:17'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), 'datetime', '2015-09-01 00:02:03'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), 'datetime', '2015-02-15 15:16:17'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), 'datetime', '2015-08-31 23:02:03'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), 'datetimecombo', '2015-02-15 15:16:17'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), 'datetimecombo', '2015-09-01 00:02:03'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), 'datetimecombo', '2015-02-15 15:16:17'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), 'datetimecombo', '2015-08-31 23:02:03'),
        );
    }
    /**
     * @dataProvider asDbTypeProvider
     */
    public function testasDbType($datetime, $type, $expected)
    {
        $timedate = new TimeDate();
        $this->assertSame($expected, $timedate->asDbType($datetime,$type));
    }

    public function asUserProvider()
    {
        $utc = new DateTimeZone('UTC');
        $gb = new DateTimeZone('Europe/London');
        $map = array(
            array('datef','global','d-m-Y'),
            array('timef','global', 'H i s')
        );
        $user = $this->getMock('User');
        $user->method('getPreference')
            ->will($this->returnValueMap($map));
        return array(
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), null, '02/15/2015 15:16'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), null, '09/01/2015 00:02'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), null, '02/15/2015 15:16'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), null, '08/31/2015 23:02'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), $user, '15-02-2015 15 16 17'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), $user, '01-09-2015 00 02 03'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), $user, '15-02-2015 15 16 17'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), $user, '31-08-2015 23 02 03'),

        );
    }
    /**
     * @dataProvider asUserProvider
     */
    public function testasUser($datetime, $user, $expected)
    {
        $timedate = new TimeDate();
        $this->assertSame($expected, $timedate->asUser($datetime,$user));
    }

    public function asUserTypeProvider()
    {
        $utc = new DateTimeZone('UTC');
        $gb = new DateTimeZone('Europe/London');
        $map = array(
            array('datef','global','d-m-Y'),
            array('timef','global', 'H i s')
        );
        $user = $this->getMock('User');
        $user->method('getPreference')
            ->will($this->returnValueMap($map));
        return array(
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), 'date', null, '02/15/2015'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), 'date', null, '09/01/2015'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), 'date', null, '02/15/2015'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), 'date', null, '08/31/2015'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), 'date', $user, '15-02-2015'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), 'date', $user, '01-09-2015'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), 'date', $user, '15-02-2015'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), 'date', $user, '31-08-2015'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), 'time', null, '15:16'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), 'time', null, '00:02'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), 'time', null, '15:16'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), 'time', null, '23:02'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), 'time', $user, '15 16 17'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), 'time', $user, '00 02 03'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), 'time', $user, '15 16 17'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), 'time', $user, '23 02 03'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), 'datetime', null, '02/15/2015 15:16'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), 'datetime', null, '09/01/2015 00:02'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), 'datetime', null, '02/15/2015 15:16'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), 'datetime', null, '08/31/2015 23:02'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), 'datetime', $user, '15-02-2015 15 16 17'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), 'datetime', $user, '01-09-2015 00 02 03'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), 'datetime', $user, '15-02-2015 15 16 17'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), 'datetime', $user, '31-08-2015 23 02 03'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), 'datetimecombo', null, '02/15/2015 15:16'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), 'datetimecombo', null, '09/01/2015 00:02'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), 'datetimecombo', null, '02/15/2015 15:16'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), 'datetimecombo', null, '08/31/2015 23:02'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), 'datetimecombo', $user, '15-02-2015 15 16 17'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), 'datetimecombo', $user, '01-09-2015 00 02 03'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), 'datetimecombo', $user, '15-02-2015 15 16 17'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), 'datetimecombo', $user, '31-08-2015 23 02 03'),
        );
    }
    /**
     * @dataProvider asUserTypeProvider
     */
    public function testasUserType($datetime, $type, $user, $expected)
    {
        $timedate = new TimeDate();
        $this->assertSame($expected, $timedate->asUserType($datetime,$type,$user));
    }

    public function asUserTsProvider()
    {
        $utc = new DateTimeZone('UTC');
        $gb = new DateTimeZone('Europe/London');
        $map = array(
            array('datef','global','d-m-Y'),
            array('timef','global', 'H i s')
        );
        $user = $this->getMock('User');
        $user->method('getPreference')
            ->will($this->returnValueMap($map));
        return array(
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), null, 1424013377),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), null, 1441065723),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), null, 1424013377),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), null, 1441062123),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), $user, 1424013377),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), $user, 1441065723),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), $user, 1424013377),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), $user, 1441062123),

        );
    }

    /**
     * @dataProvider asUserTsProvider
     */
    public function testasUserTs($datetime,$user, $expected)
    {
        $timedate = new TimeDate();
        $this->assertSame($expected, $timedate->asUserTs($datetime,$user));
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
