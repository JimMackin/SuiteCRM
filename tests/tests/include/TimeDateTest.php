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
    public function asDbDateProvider()
    {
        $utc = new DateTimeZone('UTC');
        $gb = new DateTimeZone('Europe/London');
        return array(
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), true, '2015-02-15'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), true, '2015-09-01'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), true, '2015-02-15'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), true, '2015-08-31'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), false, '2015-02-15'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), false, '2015-09-01'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), false, '2015-02-15'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), false, '2015-09-01'),
        );
    }
    /**
     * @dataProvider asDbDateProvider
     */
    public function testasDbDate($datetime, $tz, $expected)
    {
        $timedate = new TimeDate();
        $this->assertSame($expected, $timedate->asDbDate($datetime,$tz));
    }

    public function asUserDateProvider()
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
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), true, null, '02/15/2015'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), true, null, '09/01/2015'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), true, null, '02/15/2015'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), true, null, '08/31/2015'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), true, $user, '15-02-2015'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), true, $user, '01-09-2015'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), true, $user, '15-02-2015'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), true, $user, '31-08-2015'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), false, null, '02/15/2015'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), false, null, '09/01/2015'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), false, null, '02/15/2015'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), false, null, '09/01/2015'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), false, $user, '15-02-2015'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), false, $user, '01-09-2015'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), false, $user, '15-02-2015'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), false, $user, '01-09-2015'),
        );
    }

    /**
     * @dataProvider asUserDateProvider
     */
    public function testasUserDate($datetime, $tz, $user, $expected)
    {
        $timedate = new TimeDate();
        $this->assertSame($expected, $timedate->asUserDate($datetime, $tz, $user));
    }

    public function asDbTimeProvider()
    {
        $utc = new DateTimeZone('UTC');
        $gb = new DateTimeZone('Europe/London');
        return array(
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), '15:16:17'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), '00:02:03'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), '15:16:17'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), '23:02:03'),
        );
    }
    /**
     * @dataProvider asDbTimeProvider
     */
    public function testasDbTime($datetime, $expected)
    {
        $timedate = new TimeDate();
        $this->assertSame($expected, $timedate->asDbTime($datetime));
    }

    public function asUserTimeProvider()
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
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), null, '15:16'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), null, '00:02'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), null, '15:16'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), null, '23:02'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), $user, '15 16 17'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), $user, '00 02 03'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), $user, '15 16 17'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), $user, '23 02 03'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), null, '15:16'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), null, '00:02'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), null, '15:16'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), null, '23:02'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$utc), $user, '15 16 17'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$utc), $user, '00 02 03'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:17',$gb), $user, '15 16 17'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:03',$gb), $user, '23 02 03'),
        );
    }
    /**
     * @dataProvider asUserTimeProvider
     */
    public function testasUserTime($datetime, $user, $expected)
    {
        $timedate = new TimeDate();
        $this->assertSame($expected, $timedate->asUserTime($datetime, $user));
    }


    public function fromDbProvider()
    {
        $utc = new DateTimeZone('UTC');
        return array(
            array('2015-09-01 00:02:03', SugarDateTime::createFromFormat('Y-m-d H:i:s','2015-09-01 00:02:03', $utc)),
            array('2015-02-15 15:16:17', SugarDateTime::createFromFormat('Y-m-d H:i:s','2015-02-15 15:16:17', $utc)),
            array('2015-10-04', null),
            array('13:14:15', null),
            array('04/05/2015 12:14:14', null),
        );
    }
    /**
     * @dataProvider fromDbProvider
     */
    public function testfromDb($date, $expected)
    {
        $timedate = new TimeDate();
        $this->assertEquals($expected, $timedate->fromDb($date));
    }

    public function fromDbTypeProvider()
    {
        return array(
            array('2015-09-01 00:02:03', 'date', false),
            array('2015-02-15 15:16:17', 'date', false),
            array('2015-09-01', 'date', '2015-09-01'),
            array('2015-02-15', 'date', '2015-02-15'),
            array('12/04/2015', 'date', false),
            array('13:14:15', 'date', false),
            array('04/05/2015 12:14:14', 'date', false),
            array('2015-09-01 00:02:03', 'time', false),
            array('2015-02-15 15:16:17', 'time', false),
            array('2015-10-04', 'time', false),
            array('13:14:15', 'time', '13:14:15'),
            array('25:14:15', 'time', '01:14:15'),
            array('04/05/2015 12:14:14', 'time', false),
            array('2015-09-01 00:02:03', 'datetime', '2015-09-01 00:02:03'),
            array('2015-02-15 15:16:17', 'datetime', '2015-02-15 15:16:17'),
            array('2015-10-04', 'datetime', false),
            array('13:14:15', 'datetime', false),
            array('04/05/2015 12:14:14', 'datetime', false),
            array('2015-09-01 00:02:03', 'datetimecombo', '2015-09-01 00:02:03'),
            array('2015-02-15 15:16:17', 'datetimecombo', '2015-02-15 15:16:17'),
            array('2015-10-04', 'datetimecombo', false),
            array('13:14:15', 'datetimecombo', false),
            array('04/05/2015 12:14:14', 'datetimecombo', false),
        );
    }

    /**
     * @dataProvider fromDbTypeProvider
     */
    public function testfromDbType($date, $type, $expected)
    {

        $timedate = new TimeDate();
        switch($type){
            case 'date':
                $format = 'Y-m-d';
                break;
            case 'time':
                $format = 'H:i:s';
                break;
            case 'datetime':
            case 'datetimecombo':
                $format = 'Y-m-d H:i:s';
                break;
        }
        $res = $timedate->fromDbType($date, $type);
        if($res){
            $this->assertSame($expected,$res->format($format));
        }else{
            $this->assertSame($expected, $res);
        }


    }
    public function fromDbDateProvider()
    {
        return array(
            array('2015-09-01 00:02:03', false),
            array('2015-02-15 15:16:17', false),
            array('2015-09-01', '2015-09-01'),
            array('2015-02-15', '2015-02-15'),
            array('12/04/2015', false),
            array('13:14:15', false),
            array('04/05/2015 12:14:14', false),
        );
    }
    /**
     * @dataProvider fromDbDateProvider
     */
    public function testfromDbDate($date, $expected)
    {
        $timedate = new TimeDate();

        $res = $timedate->fromDbDate($date);
        if($res){
            $this->assertSame($expected,$res->format('Y-m-d'));
        }else{
            $this->assertSame($expected, $res);
        }
    }

    public function fromDbFormatProvider()
    {
        return array(
            array('2015-09-01 00:02:03', 'Y-m-d H:i:s', '2015-09-01 00:02:03', 'Y-m-d H:i:s'),
            array('2015-02-15 15:16:17', 'Y-m-d H:i:s', '2015-02-15 15:16:17', 'Y-m-d H:i:s'),
             array('2015-09-01', 'Y-m-d', '2015-09-01', 'Y-m-d'),
             array('2015-02-15', 'Y-m-d', '2015-02-15', 'Y-m-d'),
             array('12/04/2015', 'm/d/Y', '2015-12-04', 'Y-m-d'),
             array('13:14:15', 'H:i:s', '13:14:15', 'H:i:s'),
             array('04/05/2015 12:14:14', 'd/m/Y H:i:s', '2015-05-04 12:14:14', 'Y-m-d H:i:s'),
            array('2015-09-01 00:02:03', 'Y-m-d', false, 'Y-m-d H:i:s'),
            array('2015-02-15 15:16:17', 'Y-m-d H:i', false, 'Y-m-d H:i:s'),
            array('2015-09-01', 'Y/m/d', false, 'Y-m-d'),
            array('2015-02-15', 'Y-m-d H:i:s', false, 'Y-m-d'),
            array('12/04/2015', 'Y-m-d', false, 'Y-m-d'),
            array('2014-12-12 13:14:15', 'H:i:s', false, 'H:i:s'),
            array('13/15/2015 12:14:14', 'd/m/Y', false, 'Y-m-d H:i:s'),
        );
    }
    /**
     * @dataProvider fromDbFormatProvider
     */
    public function testfromDbFormat($date, $format, $expected, $cmpFormat)
    {
        $timedate = new TimeDate();

        $res = $timedate->fromDbFormat($date, $format);
        if($res){
            $this->assertSame($expected,$res->format($cmpFormat));
        }else{
            $this->assertSame($expected, $res);
        }
    }

    public function fromUserProvider()
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
            array('02/15/2015 15:16', null, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:00',$utc)),
            array('09/01/2015 00:02', null, DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:00',$utc)),
            array('2015-02-15 15:16:17', null, null),
            array('2015-09-01 00:02:03', null, null),
            array('15-02-2015 15 16 03', $user, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 15:16:03',$utc)),
            array('01-09-2015 00 02 16', $user, DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:02:16',$utc)),
            array('2015-02-15 15:16:17', $user, null),
            array('2015-09-01 00:02:03', $user, null),
        );
    }
    /**
     * @dataProvider fromUserProvider
     */
    public function testfromUser($date, $user, $expected)
    {
        $timedate = new TimeDate();
        $this->assertEquals($expected, $timedate->fromUser($date, $user));
    }

    public function fromUserTypeProvider()
    {
        $map = array(
            array('datef','global','d-m-Y'),
            array('timef','global', 'H i s')
        );
        $user = $this->getMock('User');
        $user->method('getPreference')
            ->will($this->returnValueMap($map));

        return array(
            array('02/15/2015', 'date', null, '2015-02-15','Y-m-d'),
            array('09/01/2015', 'date', null, '2015-09-01','Y-m-d'),
            array('2015-02-15', 'date', null, null,'Y-m-d'),
            array('2015-09-01', 'date', null, null, 'Y-m-d'),
            array('15-02-2015', 'date', $user, '2015-02-15', 'Y-m-d'),
            array('01-09-2015', 'date', $user, '2015-09-01', 'Y-m-d'),
            array('2015-02-15', 'date', $user, null,'Y-m-d'),
            array('2015-09-01', 'date', $user, null,'Y-m-d'),

            array('15:16', 'time', null, '15:16:00', 'H:i:s'),
            array('00:02', 'time', null, '00:02:00', 'H:i:s'),
            array('2015-02-15 15:16:17', 'time', null, false, 'H:i:s'),
            array('2015-09-01 00:02:03', 'time', null, false, 'H:i:s'),
            array('15 16 03', 'time', $user, '15:16:03', 'H:i:s'),
            array('00 02 16', 'time', $user, '00:02:16', 'H:i:s'),
            array('2015-02-15 15:16:17', 'time', $user, false, 'H:i:s'),
            array('2015-09-01 00:02:03', 'time', $user, false, 'H:i:s'),

            array('02/15/2015 15:16', 'datetime', null, '2015-02-15 15:16:00', 'Y-m-d H:i:s'),
            array('09/01/2015 00:02', 'datetime', null, '2015-09-01 00:02:00', 'Y-m-d H:i:s'),
            array('2015-02-15 15:16:17', 'datetime', null, null, 'Y-m-d H:i:s'),
            array('2015-09-01 00:02:03', 'datetime', null, null, 'Y-m-d H:i:s'),
            array('15-02-2015 15 16 03', 'datetime', $user, '2015-02-15 15:16:03', 'Y-m-d H:i:s'),
            array('01-09-2015 00 02 16', 'datetime', $user, '2015-09-01 00:02:16', 'Y-m-d H:i:s'),
            array('2015-02-15 15:16:17', 'datetime', $user, null, 'Y-m-d H:i:s'),
            array('2015-09-01 00:02:03', 'datetime', $user, null, 'Y-m-d H:i:s'),

            array('02/15/2015 15:16', 'datetimecombo', null, '2015-02-15 15:16:00', 'Y-m-d H:i:s'),
            array('09/01/2015 00:02', 'datetimecombo', null, '2015-09-01 00:02:00', 'Y-m-d H:i:s'),
            array('2015-02-15 15:16:17', 'datetimecombo', null, null, 'Y-m-d H:i:s'),
            array('2015-09-01 00:02:03', 'datetimecombo', null, null, 'Y-m-d H:i:s'),
            array('15-02-2015 15 16 03', 'datetimecombo', $user, '2015-02-15 15:16:03', 'Y-m-d H:i:s'),
            array('01-09-2015 00 02 16', 'datetimecombo', $user, '2015-09-01 00:02:16', 'Y-m-d H:i:s'),
            array('2015-02-15 15:16:17', 'datetimecombo', $user, null, 'Y-m-d H:i:s'),
            array('2015-09-01 00:02:03', 'datetimecombo', $user, null, 'Y-m-d H:i:s'),
        );
    }
    /**
     * @dataProvider fromUserTypeProvider
     */
    public function testfromUserType($date, $type, $user, $expected, $cmpFormat)
    {
        $timedate = new TimeDate();
        $res = $timedate->fromUserType($date, $type, $user);
        if($res){
            $this->assertSame($expected, $res->format($cmpFormat));
        }else{
            $this->assertSame($expected, $res);
        }
    }

    public function fromUserTimeProvider()
    {
        $map = array(
            array('datef','global','d-m-Y'),
            array('timef','global', 'H i s')
        );
        $user = $this->getMock('User');
        $user->method('getPreference')
            ->will($this->returnValueMap($map));

        return array(
            array('15:16', null, '15:16:00'),
            array('00:02', null, '00:02:00'),
            array('2015-02-15 15:16:17', null, false),
            array('2015-09-01 00:02:03', null, false),
            array('15 16 03', $user, '15:16:03'),
            array('00 02 16', $user, '00:02:16'),
            array('2015-02-15 15:16:17', $user, false),
            array('2015-09-01 00:02:03', $user, false),
        );
    }
    /**
     * @dataProvider fromUserTimeProvider
     */
    public function testfromUserTime($date, $user, $expected)
    {
        $timedate = new TimeDate();
        $res = $timedate->fromUserTime($date, $user);
        if($res){
            $this->assertSame($expected, $res->format('H:i:s'));
        }else{
            $this->assertSame($expected, $res);
        }
    }

    public function fromUserDateProvider()
    {
        $map = array(
            array('datef','global','d-m-Y'),
            array('timef','global', 'H i s'),
            array('timezone','global','Pacific/Auckland')
        );
        $user = $this->getMock('User');
        $user->method('getPreference')
            ->will($this->returnValueMap($map));

        return array(
            array('02/15/2015', true, null, '2015-02-15'),
            array('09/01/2015', true, null, '2015-09-01'),
            array('2015-02-15', true, null, false),
            array('2015-09-01', true, null, false),
            array('15-02-2015', true, $user, '2015-02-15'),
            array('01-09-2015', true, $user, '2015-09-01'),
            array('2015-02-15', true, $user, false),
            array('2015-09-01', true, $user, false),
            array('02/15/2015', false, null, '2015-02-15'),
            array('09/01/2015', false, null, '2015-09-01'),
            array('2015-02-15', false, null, false),
            array('2015-09-01', false, null, false),
            array('15-02-2015', false, $user, '2015-02-15'),
            array('01-09-2015', false, $user, '2015-09-01'),
            array('2015-02-15', false, $user, false),
            array('2015-09-01', false, $user, false),
        );
    }
    /**
     * @dataProvider fromUserDateProvider
     */
    public function testfromUserDate($date, $convertTz, $user, $expected)
    {
        $timedate = new TimeDate();
        $res = $timedate->fromUserDate($date, $convertTz, $user);
        if($res){
            $this->assertSame($expected, $res->format('Y-m-d'));
        }else{
            $this->assertSame($expected, $res);
        }

    }

    public function fromStringProvider()
    {
        $map = array(
            array('datef','global','d-m-Y'),
            array('timef','global', 'H i s'),
            array('timezone','global','Pacific/Auckland')
        );
        $user = $this->getMock('User');
        $user->method('getPreference')
            ->will($this->returnValueMap($map));

        return array(
            array('02/15/2015', null, '2015-02-15' ,'Y-m-d'),
            array('09/01/2015', null, '2015-09-01' ,'Y-m-d'),
            array('2015-02-15', null, '2015-02-15' ,'Y-m-d'),
            array('2015-09-01', null, '2015-09-01', 'Y-m-d'),
            array('15-02-2015', $user, '2015-02-15', 'Y-m-d'),
            array('01-09-2015', $user, '2015-09-01', 'Y-m-d'),
            array('2015-02-15', $user, '2015-02-15', 'Y-m-d'),
            array('2015-09-01', $user, '2015-09-01', 'Y-m-d'),

            array('@946684800', null, '2000-01-01', 'Y-m-d'),
            array('@946684800', $user, '2000-01-01', 'Y-m-d'),

            array('2000-02-30', null, '2000-03-01', 'Y-m-d'),
            array('2000-02-30', $user, '2000-03-01', 'Y-m-d'),

            array('5pm', null, '17:00:00', 'H:i:s'),
            array('5pm', $user, '17:00:00', 'H:i:s'),

            array('May-09-78', null, '1978-05-09', 'Y-m-d'),
            array('May-09-78', $user, '1978-05-09', 'Y-m-d'),
        );
    }
    /**
     * @dataProvider fromStringProvider
     */
    public function testfromString($string, $user, $expected, $cmpFormat)
    {
        $timedate = new TimeDate();
        $res = $timedate->fromString($string, $user);
        if($res){
            $this->assertSame($expected, $res->format($cmpFormat));
        }else{
            $this->assertSame($expected, $res);
        }
    }
    public function fromTimestampProvider()
    {
        $utc = new DateTimeZone('UTC');
        return array(
            array('1423042061', DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-04 09:27:41',$utc)),
            array('515682600', DateTime::createFromFormat('Y-m-d H:i:s', '1986-05-05 13:10:00',$utc)),
            array('12345', DateTime::createFromFormat('Y-m-d H:i:s', '1970-01-01 03:25:45',$utc)),
            array('-1000', DateTime::createFromFormat('Y-m-d H:i:s', '1969-12-31 23:43:20',$utc)),
            array('invalid', null, true),
            array(null, null, true),
        );
    }
    /**
     * @dataProvider fromTimestampProvider
     */
    public function testfromTimestamp($timestamp, $expected, $expectException = false)
    {
        $timedate = new TimeDate();
        if($expectException){
            $this->setExpectedException('Exception');
        }
        $this->assertEquals($expected, $timedate->fromTimestamp($timestamp));

    }

    public function tzGMTProvider()
    {
        $utc = new DateTimeZone('UTC');
        $gb = new DateTimeZone('Europe/London');
        $nz = new DateTimeZone('Pacific/Auckland');
        return array(
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$utc), DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$utc)),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$utc), DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$utc)),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$gb), DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$utc)),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$gb), DateTime::createFromFormat('Y-m-d H:i:s', '2015-08-31 23:27:41',$utc)),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-14 09:27:41',$nz), DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-13 20:27:41',$utc)),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$nz), DateTime::createFromFormat('Y-m-d H:i:s', '2015-08-31 12:27:41',$utc)),
        );
    }
    /**
     * @dataProvider tzGMTProvider
     */
    public function testtzGMT($date, $expected)
    {
        $timedate = new TimeDate();
        $res = $timedate->tzGMT($date);
        $this->assertEquals($expected, $res);
        $utc = new DateTimeZone('UTC');
        $this->assertEquals($utc, $res->getTimezone());
    }

    public function tzUserProvider()
    {
        $utc = new DateTimeZone('UTC');
        $gb = new DateTimeZone('Europe/London');
        $nz = new DateTimeZone('Pacific/Auckland');

        $utcuser = $this->getMock('User');
        $utcuser->id = 2;
        $utcuser->method('getPreference')
            ->will($this->returnValue('UTC'));
        $gbuser = $this->getMock('User');
        $gbuser->id = 3;
        $gbuser->method('getPreference')
            ->will($this->returnValue('Europe/London'));
        $nzuser = $this->getMock('User');
        $nzuser->id = 4;
        $nzuser->method('getPreference')
            ->will($this->returnValue('Pacific/Auckland'));
        return array(
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$utc), null, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$utc)),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$utc), null, DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$utc)),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$gb), null, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$utc)),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$gb), null, DateTime::createFromFormat('Y-m-d H:i:s', '2015-08-31 23:27:41',$utc)),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-14 09:27:41',$nz), null, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-13 20:27:41',$utc)),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$nz), null, DateTime::createFromFormat('Y-m-d H:i:s', '2015-08-31 12:27:41',$utc)),

            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$utc), $utcuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$utc)),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$utc), $utcuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$utc)),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$gb), $utcuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$utc)),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$gb), $utcuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-08-31 23:27:41',$utc)),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-14 09:27:41',$nz), $utcuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-13 20:27:41',$utc)),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$nz), $utcuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-08-31 12:27:41',$utc)),

            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$utc), $gbuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$gb)),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$utc), $gbuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 01:27:41',$gb)),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$gb), $gbuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$gb)),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$gb), $gbuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$gb)),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-14 09:27:41',$nz), $gbuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-13 20:27:41',$gb)),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$nz), $gbuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-08-31 13:27:41',$gb)),

            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$utc), $nzuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 22:27:41',$nz)),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$utc), $nzuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 12:27:41',$nz)),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$gb), $nzuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 22:27:41',$nz)),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$gb), $nzuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 11:27:41',$nz)),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-14 09:27:41',$nz), $nzuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-14 09:27:41',$nz)),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$nz), $nzuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$nz)),
        );
    }
    /**
     * @dataProvider tzUserProvider
     */
    public function testtzUser($date, $user, $expected)
    {
        $timedate = new TimeDate();
        $res = $timedate->tzUser($date, $user);
        $this->assertEquals($expected, $res);
        $this->assertEquals($expected->getTimezone(), $res->getTimezone());
    }

    public function to_display_date_timeProvider()
    {
        $utc = new DateTimeZone('UTC');
        $gb = new DateTimeZone('Europe/London');
        $nz = new DateTimeZone('Pacific/Auckland');

        $utcmap = array(
            array('datef','global','Y-m-d'),
            array('timef','global', 'H:i:s'),
            array('timezone','global','UTC')
        );
        $gbmap = array(
            array('datef','global','d-m-Y'),
            array('timef','global', 'H i s'),
            array('timezone','global','Europe/London')
        );
        $nzmap = array(
            array('datef','global','m/d/Y'),
            array('timef','global', 'H:i'),
            array('timezone','global','Pacific/Auckland')
        );
        $utcuser = $this->getMock('User');
        $utcuser->id = 2;
        $utcuser->method('getPreference')
            ->will($this->returnValueMap($utcmap));
        $gbuser = $this->getMock('User');
        $gbuser->id = 3;
        $gbuser->method('getPreference')
            ->will($this->returnValueMap($gbmap));
        $nzuser = $this->getMock('User');
        $nzuser->id = 4;
        $nzuser->method('getPreference')
            ->will($this->returnValueMap($nzmap));
        return array(
            array('2015-02-15 09:27:41', true, true, $utcuser, '2015-02-15 09:27:41'),
            array('2015-09-01 00:27:41', true, true, $utcuser, '2015-09-01 00:27:41'),
            array('2015-02-15 09:27:41', true, false, $utcuser, '2015-02-15 09:27:41'),
            array('2015-09-01 00:27:41', true, false, $utcuser, '2015-09-01 00:27:41'),
            array('2015-02-15 09:27:41', false, true, $utcuser, '2015-02-15 09:27:41'),
            array('2015-09-01 00:27:41', false, true, $utcuser, '2015-09-01 00:27:41'),
            array('2015-02-15 09:27:41', false, false, $utcuser, '2015-02-15 09:27:41'),
            array('2015-09-01 00:27:41', false, false, $utcuser, '2015-09-01 00:27:41'),

            array('2015-02-15 09:27:41', true, true, $gbuser, '15-02-2015 09 27 41'),
            array('2015-09-01 00:27:41', true, true, $gbuser, '01-09-2015 01 27 41'),
            array('2015-02-15 09:27:41', true, false, $gbuser, '15-02-2015 09 27 41'),
            array('2015-09-01 00:27:41', true, false, $gbuser, '01-09-2015 00 27 41'),
            array('2015-02-15 09:27:41', false, true, $gbuser, '15-02-2015 09 27 41'),
            array('2015-09-01 00:27:41', false, true, $gbuser, '01-09-2015 01 27 41'),
            array('2015-02-15 09:27:41', false, false, $gbuser, '15-02-2015 09 27 41'),
            array('2015-09-01 00:27:41', false, false, $gbuser, '01-09-2015 00 27 41'),

            array('2015-02-15 09:27:41', true, true, $nzuser, '02/15/2015 22:27'),
            array('2015-09-01 00:27:41', true, true, $nzuser, '09/01/2015 12:27'),
            array('2015-02-15 09:27:41', true, false, $nzuser, '02/15/2015 09:27'),
            array('2015-09-01 00:27:41', true, false, $nzuser, '09/01/2015 00:27'),
            array('2015-02-15 09:27:41', false, true, $nzuser, '02/15/2015 22:27'),
            array('2015-09-01 00:27:41', false, true, $nzuser, '09/01/2015 12:27'),
            array('2015-02-15 09:27:41', false, false, $nzuser, '02/15/2015 09:27'),
            array('2015-09-01 00:27:41', false, false, $nzuser, '09/01/2015 00:27'),
        );
    }
    /**
     * @dataProvider to_display_date_timeProvider
     */
    public function testto_display_date_time($date, $meridiem, $convert_tz, $user, $expected)
    {
        $timedate = new TimeDate();
        $res = $timedate->to_display_date_time($date, $meridiem, $convert_tz, $user);
        $this->assertEquals($expected, $res);
    }

    public function to_display_timeProvider()
    {
        return array(
            array('2015-02-15 09:27:41', true, true, '09:27'),
            array('2015-09-01 00:27:41', true, true, '00:27'),
            array('2015-09-01 22:27:41', true, true, '22:27'),
            array('2015-02-15 09:27:41', true, false, '09:27'),
            array('2015-09-01 00:27:41', true, false, '00:27'),
            array('2015-09-01 22:27:41', true, false, '22:27'),
            array('2015-02-15 09:27:41', false, true, '09:27'),
            array('2015-09-01 00:27:41', false, true, '00:27'),
            array('2015-09-01 22:27:41', false, true, '22:27'),
            array('2015-02-15 09:27:41', false, false, '09:27'),
            array('2015-09-01 00:27:41', false, false, '00:27'),
            array('2015-09-01 22:27:41', false, false, '22:27'),

            array('09:27:41', true, true, '09:27'),
            array('00:27:41', true, true, '00:27'),
            array('22:27:41', true, true, '22:27'),
            array('09:27:41', true, false, '09:27'),
            array('00:27:41', true, false, '00:27'),
            array('22:27:41', true, false, '22:27'),
            array('09:27:41', false, true, '09:27'),
            array('00:27:41', false, true, '00:27'),
            array('22:27:41', false, true, '22:27'),
            array('09:27:41', false, false, '09:27'),
            array('00:27:41', false, false, '00:27'),
            array('22:27:41', false, false, '22:27'),

            array('invalid', false, false, ''),
        );
    }
    /**
     * @dataProvider to_display_timeProvider
     */
    public function testto_display_time($date, $meridiem, $convert_tz, $expected)
    {
        $timedate = new TimeDate();
        $this->assertEquals($expected, $timedate->to_display_time($date, $meridiem,$convert_tz));
    }

    public function splitTimeProvider()
    {
        return array(

            array('09:27:41', 'H:i:s', array('h'=>'09','m'=>'27','s'=>'41')),
            array('00:27:41', 'H:i:s', array('h'=>'00','m'=>'27','s'=>'41')),
            array('22:27:41', 'H:i:s', array('h'=>'22','m'=>'27','s'=>'41')),

            array('09 27', 'H i', array('h'=>'09','m'=>'27','s'=>'00')),
            array('00 27', 'H i', array('h'=>'00','m'=>'27','s'=>'00')),
            array('22 27', 'H i', array('h'=>'22','m'=>'27','s'=>'00')),

            array('09:27 am', 'H:i a', array('h'=>'09','m'=>'27','s'=>'00','a'=>'am')),
            array('01:27 am', 'H:i a', array('h'=>'01','m'=>'27','s'=>'00','a'=>'am')),
            array('11:27 pm', 'H:i a', array('h'=>'11','m'=>'27','s'=>'00','a'=>'pm')),
            array('10:27 pm', 'H:i A', array('h'=>'10','m'=>'27','s'=>'00','a'=>'PM')),
            //array('09:27', 'H:i:s', array('h'=>'09','m'=>'27','s'=>'41')),
            //array('invalid', 'H:i:s', array()),
        );
    }
    /**
     * @dataProvider splitTimeProvider
     */
    public function testsplitTime($date, $format, $expected)
    {
        $timedate = new TimeDate();
        $this->assertEquals($expected, $timedate->splitTime($date, $format));
    }

    public function to_display_dateProvider()
    {
        $utcmap = array(
            array('datef','global','Y-m-d'),
            array('timef','global', 'H:i:s'),
            array('timezone','global','UTC')
        );
        $gbmap = array(
            array('datef','global','d-m-Y'),
            array('timef','global', 'H i s'),
            array('timezone','global','Europe/London')
        );
        $nzmap = array(
            array('datef','global','m/d/Y'),
            array('timef','global', 'H:i'),
            array('timezone','global','Pacific/Auckland')
        );
        $utcuser = $this->getMock('User');
        $utcuser->id = 2;
        $utcuser->method('getPreference')
            ->will($this->returnValueMap($utcmap));
        $gbuser = $this->getMock('User');
        $gbuser->id = 3;
        $gbuser->method('getPreference')
            ->will($this->returnValueMap($gbmap));
        $nzuser = $this->getMock('User');
        $nzuser->id = 4;
        $nzuser->method('getPreference')
            ->will($this->returnValueMap($nzmap));
        return array(
            array('2015-02-15 09:27:41', true, $utcuser, '2015-02-15'),
            array('2015-09-01 00:27:41', true, $utcuser, '2015-09-01'),
            array('2015-02-15 09:27:41', false, $utcuser, '2015-02-15'),
            array('2015-09-01 00:27:41', false, $utcuser, '2015-09-01'),
            array('2015-02-15', true, $utcuser, '2015-02-15'),
            array('2015-09-01', true, $utcuser, '2015-09-01'),
            array('2015-02-15', false, $utcuser, '2015-02-15'),
            array('2015-09-01', false, $utcuser, '2015-09-01'),

            array('2015-02-15 09:27:41', true, $gbuser, '15-02-2015'),
            array('2015-09-01 00:27:41', true, $gbuser, '01-09-2015'),
            array('2015-02-15 09:27:41', false, $gbuser, '15-02-2015'),
            array('2015-09-01 00:27:41', false, $gbuser, '01-09-2015'),
            array('2015-02-15', true, $gbuser, '15-02-2015'),
            array('2015-09-01', true, $gbuser, '01-09-2015'),
            array('2015-02-15', false, $gbuser, '15-02-2015'),
            array('2015-09-01', false, $gbuser, '01-09-2015'),

            array('2015-02-15 09:27:41', true, $nzuser, '02/15/2015'),
            array('2015-09-01 00:27:41', true, $nzuser, '09/01/2015'),
            array('2015-02-15 09:27:41', false, $nzuser, '02/15/2015'),
            array('2015-09-01 00:27:41', false, $nzuser, '09/01/2015'),
            array('2015-02-15', true, $nzuser, '02/15/2015'),
            array('2015-09-01', true, $nzuser, '09/01/2015'),
            array('2015-02-15', false, $nzuser, '02/15/2015'),
            array('2015-09-01', false, $nzuser, '09/01/2015'),

            array('2015-09', false, $utcuser, ''),
        );
    }
    /**
     * @dataProvider to_display_dateProvider
     */
    public function testto_display_date($date, $convert_tz, $user, $expected)
    {
        $timedate = new TimeDate();
        $timedate->setUser($user);
        $this->assertEquals($expected, $timedate->to_display_date($date, $convert_tz));
    }

    public function to_displayProvider()
    {
        return array(
            array('2015-02-15 09:27:41', 'Y-m-d H:i:s', 'Y-m-d', '2015-02-15'),
            array('2015-09-01 00:27:41', 'Y-m-d H:i:s', 'Y-m-d', '2015-09-01'),

            array('2015-02-15', 'Y-m-d', 'Y-m-d', '2015-02-15'),
            array('2015-09-01', 'Y-m-d', 'Y-m-d', '2015-09-01'),

            array('15/02/2015 09 27', 'd/m/Y H i', 'd m Y H i s', '15 02 2015 09 27 00'),
            array('01/09/2015 00 27', 'd/m/Y H i', 'd m Y H i s', '01 09 2015 00 27 00'),

            array('2015-02-15 09:27:41', 'Y-m-d', 'Y-m-d', ''),
            array('2015-09-01 00:27:41', 'Y-m-d', 'Y-m-d', ''),
        );
    }
    /**
     * @dataProvider to_displayProvider
     */
    public function testto_display($date, $from, $to, $expected)
    {
        $timedate = new TimeDate();
        $this->assertEquals($expected, $timedate->to_display($date, $from, $to));
    }

    public function testget_db_date_time_format()
    {
        $timedate = new TimeDate();
        $this->assertEquals('Y-m-d H:i:s', $timedate->get_db_date_time_format());
    }

    public function testget_db_date_format()
    {
        $timedate = new TimeDate();
        $this->assertEquals('Y-m-d', $timedate->get_db_date_format());
    }

    public function testget_db_time_format()
    {
        $timedate = new TimeDate();
        $this->assertEquals('H:i:s', $timedate->get_db_time_format());
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
    public function guessTimezoneProvider()
    {
        return array(
            array(-720,null),
            array(-660,'Pacific/Midway'),
            array(-300,'America/New_York'),
            array(-30,null),
            array(0,'Europe/London'),
            array(30,null),
            array(60,'Europe/Amsterdam'),
            array(420,'Asia/Jakarta'),
            array(660,'Australia/Sydney'),
            array(840,'Pacific/Apia'),
            array(870,null),
        );
    }
    /**
     * @dataProvider guessTimezoneProvider
     */
    public function testguessTimezone($offset, $expected)
    {
        $timedate = new TimeDate();
        $this->assertEquals($expected, $timedate->guessTimezone($offset));
    }

    public function userTimezoneSuffixProvider()
    {
        $utc = new DateTimeZone('UTC');
        $gb = new DateTimeZone('Europe/London');
        $nz = new DateTimeZone('Pacific/Auckland');

        $utcuser = $this->getMock('User');
        $utcuser->id = 2;
        $utcuser->method('getPreference')
            ->will($this->returnValue('UTC'));
        $gbuser = $this->getMock('User');
        $gbuser->id = 3;
        $gbuser->method('getPreference')
            ->will($this->returnValue('Europe/London'));
        $nzuser = $this->getMock('User');
        $nzuser->id = 4;
        $nzuser->method('getPreference')
            ->will($this->returnValue('Pacific/Auckland'));
        return array(
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$utc), null, 'UTC(+00:00)'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$utc), null, 'UTC(+00:00)'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$gb), null, 'UTC(+00:00)'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$gb), null, 'UTC(+00:00)'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-14 09:27:41',$nz), null, 'UTC(+00:00)'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$nz), null, 'UTC(+00:00)'),

            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$utc), $utcuser, 'UTC(+00:00)'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$utc), $utcuser, 'UTC(+00:00)'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$gb), $utcuser, 'UTC(+00:00)'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$gb), $utcuser, 'UTC(+00:00)'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-14 09:27:41',$nz), $utcuser, 'UTC(+00:00)'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$nz), $utcuser, 'UTC(+00:00)'),

            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$utc), $gbuser, 'GMT(+00:00)'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$utc), $gbuser, 'BST(+01:00)'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$gb), $gbuser, 'GMT(+00:00)'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$gb), $gbuser, 'BST(+01:00)'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-14 09:27:41',$nz), $gbuser, 'GMT(+00:00)'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$nz), $gbuser, 'BST(+01:00)'),

            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$utc), $nzuser, 'NZDT(+13:00)'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$utc), $nzuser, 'NZST(+12:00)'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$gb), $nzuser, 'NZDT(+13:00)'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$gb), $nzuser, 'NZST(+12:00)'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-14 09:27:41',$nz), $nzuser, 'NZDT(+13:00)'),
            array(DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:27:41',$nz), $nzuser, 'NZST(+12:00)'),
        );
    }
    /**
     * @dataProvider userTimezoneSuffixProvider
     */
    public function testuserTimezoneSuffix($date, $user, $expected)
    {
        $timedate = new TimeDate();
        $this->assertEquals($expected, $timedate->userTimezoneSuffix($date, $user));
    }

    public function tzNameProvider()
    {
        return array(
            array(new DateTimeZone('UTC'), 'timezone dom (GMT+0:00)'),
            array(new DateTimeZone('Africa/Abidjan'), 'timezone dom (GMT+0:00)'),
            array(new DateTimeZone('America/Vancouver'), 'timezone dom (GMT-8:00)'),
            array(new DateTimeZone('Antarctica/Troll'), 'timezone dom (GMT+0:00)'),
            array(new DateTimeZone('Arctic/Longyearbyen'), 'timezone dom (GMT+1:00)'),
            array(new DateTimeZone('Asia/Seoul'), 'timezone dom (GMT+9:00)'),
            array(new DateTimeZone('Atlantic/Bermuda'), 'timezone dom (GMT-4:00)'),
            array(new DateTimeZone('Australia/Perth'), 'timezone dom (GMT+8:00)'),
            array(new DateTimeZone('Europe/Amsterdam'), 'timezone dom (GMT+1:00)'),
            array(new DateTimeZone('Indian/Antananarivo'), 'timezone dom (GMT+3:00)'),
            array(new DateTimeZone('Pacific/Auckland'), 'timezone dom (GMT+13:00)'),
            array(new DateTimeZone('Universal'), 'timezone dom (GMT+0:00)'),
            array(new DateTimeZone('Etc/GMT+7'), 'timezone dom (GMT-7:00)'),

            array('UTC', 'timezone dom (GMT+0:00)'),
            array('Africa/Abidjan', 'timezone dom (GMT+0:00)'),
            array('America/Vancouver', 'timezone dom (GMT-8:00)'),
            array('Antarctica/Troll', 'timezone dom (GMT+0:00)'),
            array('Arctic/Longyearbyen', 'timezone dom (GMT+1:00)'),
            array('Asia/Seoul', 'timezone dom (GMT+9:00)'),
            array('Atlantic/Bermuda', 'timezone dom (GMT-4:00)'),
            array('Australia/Perth', 'timezone dom (GMT+8:00)'),
            array('Europe/Amsterdam', 'timezone dom (GMT+1:00)'),
            array('Indian/Antananarivo', 'timezone dom (GMT+3:00)'),
            array('Pacific/Auckland', 'timezone dom (GMT+13:00)'),
            array('Universal', 'timezone dom (GMT+0:00)'),
            array('Etc/GMT+7', 'timezone dom (GMT-7:00)'),
        );
    }
    /**
     * @dataProvider tzNameProvider
     */
    public function testtzName($name, $expected)
    {
        $timedate = new TimeDate();
        $this->assertEquals($expected, $timedate->tzName($name));
    }

    public function _sortTzProvider()
    {
        return array(
            array(array(0, 'UTC'), array(0, 'UTC'), 0),
            array(array(0, 'UTC'), array(0, 'GMT'), 1),
            array(array(0, 'GMT'), array(0, 'UTC'), -1),
            array(array(-8, 'America/Vancouver'), array(-8, 'America/Abc'), 1),
            array(array(0, 'GMT'), array(-8, 'America/Vancouver'), 1),
            array(array(-8, 'America/Vancouver'), array(8, 'Asia/Foo'), -1),
            array(array(8, 'Asia/Foo'), array(-8, 'America/Vancouver'), 1),
        );
    }
    /**
     * @dataProvider _sortTzProvider
     */
    public function test_sortTz($a, $b, $expected)
    {
        $timedate = new TimeDate();
        $cmp =  $timedate->_sortTz($a,$b);
        if($expected > 0){
            $this->assertGreaterThan(0,$cmp);
        }elseif($expected < 0){
            $this->assertLessThan(0,$cmp);
        }else{
            $this->assertSame(0,$cmp);
        }
    }

    public function testgetTimezoneList()
    {
        $timedate = new TimeDate();
        $res = $timedate->getTimezoneList();
        $this->assertEquals('timezone dom (GMT+0:00)', $res['UTC']);
    }

    public function httpTimeProvider()
    {
        $utc = new DateTimeZone('UTC');
        return array(
            array('1423042061', 'Wed, 04 Feb 2015 09:27:41 GMT'),
            array('515682600', 'Mon, 05 May 1986 13:10:00 GMT'),
            array('12345', 'Thu, 01 Jan 1970 03:25:45 GMT'),
            array('-1000', 'Wed, 31 Dec 1969 23:43:20 GMT'),
        );
    }
    /**
     * @dataProvider httpTimeProvider
     */
    public function testhttpTime($timestamp, $expected)
    {
        $timedate = new TimeDate();
        $this->assertEquals($expected, $timedate->httpTime($timestamp));
    }

    public function fromTimeArrayProvider()
    {
        $utc = new DateTimeZone('UTC');
        return array(
            array(array('year'=>'2015','month'=>'2','day'=>'15','hour'=>'9','min'=>'27','sec'=>'41'), DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 09:27:41',$utc)),
            array(array('year'=>'2015','month'=>'9','day'=>'1','hour'=>'9','min'=>'27','sec'=>'41'), DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 09:27:41',$utc)),

            array(array('year'=>'2015','month'=>'2','day'=>'15'), DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 00:00:00',$utc)),
            array(array('year'=>'2015','month'=>'9','day'=>'1'), DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 00:00:00',$utc)),
        );
    }
    /**
     * @dataProvider fromTimeArrayProvider
     */
    public function testfromTimeArray($time, $expected)
    {
        $timedate = new TimeDate();
        $this->assertEquals($expected, $timedate->fromTimeArray($time));
    }


    public function getDatePartProvider()
    {

        return array(
            array('2015-02-15 00:00:00', '2015-02-15'),
            array('2015-09-22 22:12:14', '2015-09-22'),
        );
    }
    /**
     * @dataProvider getDatePartProvider
     */
    public function testgetDatePart($date, $expected)
    {
        $timedate = new TimeDate();
        $this->assertEquals($expected, $timedate->getDatePart($date));
    }

    public function getTimePartProvider()
    {

        return array(
            array('2015-02-15 00:00:00', '00:00:00'),
            array('2015-09-22 22:12:14', '22:12:14'),
        );
    }
    /**
     * @dataProvider getTimePartProvider
     */
    public function testgetTimePart($date, $expected)
    {
        $timedate = new TimeDate();
        $this->assertEquals($expected, $timedate->getTimePart($date));
    }

    public function getUserUTCOffsetProvider()
    {
        $utc = new DateTimeZone('UTC');
        $gb = new DateTimeZone('Europe/London');
        $nz = new DateTimeZone('Pacific/Auckland');

        $utcuser = $this->getMock('User');
        $utcuser->id = 2;
        $utcuser->method('getPreference')
            ->will($this->returnValue('UTC'));
        $gbuser = $this->getMock('User');
        $gbuser->id = 3;
        $gbuser->method('getPreference')
            ->will($this->returnValue('Europe/London'));
        $nzuser = $this->getMock('User');
        $nzuser->id = 4;
        $nzuser->method('getPreference')
            ->will($this->returnValue('Pacific/Auckland'));

        return array(
            array($utcuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 01:22:00',$utc), 0),
            array($utcuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 09:24:00',$utc), 0),
            array($utcuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 01:22:00',$gb), 0),
            array($utcuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 09:24:00',$gb), 0),
            array($utcuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 01:22:00',$nz), 0),
            array($utcuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 09:24:00',$nz), 0),

            array($gbuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 01:22:00',$utc), 0),
            array($gbuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 09:24:00',$utc), 60),
            array($gbuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 01:22:00',$gb), 0),
            array($gbuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 09:24:00',$gb), 60),
            array($gbuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 01:22:00',$nz), 0),
            array($gbuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 09:24:00',$nz), 60),

            array($nzuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 01:22:00',$utc), 780),
            array($nzuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 09:24:00',$utc), 720),
            array($nzuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 01:22:00',$gb), 780),
            array($nzuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 09:24:00',$gb), 720),
            array($nzuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 01:22:00',$nz), 780),
            array($nzuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 09:24:00',$nz), 720),

        );
    }
    /**
     * @dataProvider getUserUTCOffsetProvider
     */
    public function testgetUserUTCOffset($user, $date, $expected)
    {
        $timedate = new TimeDate();
        $this->assertSame($expected, $timedate->getUserUTCOffset($user, $date));
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

    public function getUserTimeZoneProvider()
    {
        $utc = new DateTimeZone('UTC');
        $utcuser = $this->getMock('User');
        $utcuser->id = 2;
        $utcuser->method('getPreference')
            ->will($this->returnValue('UTC'));
        $gbuser = $this->getMock('User');
        $gbuser->id = 3;
        $gbuser->method('getPreference')
            ->will($this->returnValue('Europe/London'));
        $nzuser = $this->getMock('User');
        $nzuser->id = 4;
        $nzuser->method('getPreference')
            ->will($this->returnValue('Pacific/Auckland'));

        return array(
            array(null, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 01:22:00',$utc), array('gmtOffset'=>0)),
            array(null, DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 09:24:00',$utc), array('gmtOffset'=>0)),
            array($utcuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 01:22:00',$utc), array('gmtOffset'=>0)),
            array($utcuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 09:24:00',$utc), array('gmtOffset'=>0)),
            array($gbuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 01:22:00',$utc), array('gmtOffset'=>0)),
            array($gbuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 09:24:00',$utc), array('gmtOffset'=>60)),
            array($nzuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-02-15 01:22:00',$utc), array('gmtOffset'=>780)),
            array($nzuser, DateTime::createFromFormat('Y-m-d H:i:s', '2015-09-01 09:24:00',$utc), array('gmtOffset'=>720)),
        );
    }
    /**
     * @dataProvider getUserTimeZoneProvider
     */
    public function testgetUserTimeZone($user,$now, $expected)
    {
        $timedate = new TimeDate();
        $timedate->setNow($now);
        $this->assertSame($expected, $timedate->getUserTimeZone($user));
    }

    public function getDSTRangeProvider()
    {
        return array(
            array(2014,null,array()),
            array(2014,'UTC',array()),
            array(2014,'Europe/London',array('start'=>'2014-03-30 01:00:00','end'=>'2014-10-26 01:00:00')),
            array(2014,'Pacific/Auckland',array('start'=>'2014-01-01 00:00:00','end'=>'2014-04-05 14:00:00')),
            array(1940,null,array()),
            array(1940,'UTC',array()),
            array(1940,'Europe/London',array('start'=>'1940-02-25 02:00:00')),
            array(1940,'Pacific/Auckland',array('start'=>'1940-01-01 00:00:00','end'=>'1940-04-27 14:00:00')),
            array(1942,null,array()),
            array(1942,'UTC',array()),
            array(1942,'Europe/London',array('start'=>'1942-01-01 00:00:00')),
            array(1942,'Pacific/Auckland',array('start'=>'1942-01-01 00:00:00')),
            array(1971,null,array()),
            array(1971,'UTC',array()),
            array(1971,'Europe/London',array()),
            array(1971,'Pacific/Auckland',array()),
        );
    }
    /**
     * @dataProvider getDSTRangeProvider
     */
    public function testgetDSTRange($year, $zone, $expected)
    {
        $timedate = new TimeDate();
        $this->assertSame($expected, $timedate->getDSTRange($year, $zone));
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
