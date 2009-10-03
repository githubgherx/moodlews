<?php // $Id: wsdl.php,v 1.5 2007/04/28 04:05:36 PP Exp $

/**
 * This file creates a WSDL file for the web service interfaced running on
 * this server with URL paths relative to the currently running server.
 *
 * When referring to this file, you must call it as:
 *
 * http://www.yourhost.com/ ... /wspp/wsdl_pp.php
 *
 * Where ... is the path to your Moodle root.  This is so that your web server
 * will process the PHP statemtents within the file, which returns a WSDL
 * file to the web services call (or your browser).
 *
 * @version $Id: wsdl.php,v 1.4 2007/04/24 04:05:36 jfilip Exp $
 * @author Justin Filip <jfilip@oktech.ca>
 * @author Open Knowledge Technologies - http://www.oktech.ca/
 * @author PP
 *           removed the mdl_soapserver. )
 *           added extra API calls
 *           added plural when an array of whatever is required
 *           so defined get_xxx with ONE id and return one record
 *               and get_xxxs with array of id and  return array of record
 * when modifiying this file to add new API calls, run the provided
 * wsdl2php.php utility (or mkclasses.sh script) to generate uptodate
 * class names files (needed by PHP5 clients AND server) and MoodleWS class
 * (needed only by PHP5 clients)
 * rev 1.5.9 :
 *   corrected wrong parameters in get_my_courses_by* calls (removed extraneous idfield if get_my_coursesRequest)
 *   added has_primaryrole_incourse
 */


    require_once('../config.php');


  header('Content-Type: application/xml; charset=UTF-8');
//  text/xml is required by jdeveloper UDDI
//  header('Content-Type: text/xml; charset=UTF-8');

  header('Content-Disposition: attachment; filename="moodlews.wsdl"');

    echo '<?xml version="1.0" encoding="UTF-8"?>
<definitions xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
  xmlns:xsd="http://www.w3.org/2001/XMLSchema"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"
  xmlns:si="http://soapinterop.org/xsd"
  xmlns:tns="' . $CFG->wwwroot . '/wspp/wsdl"
  xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
  xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/"
  xmlns="http://schemas.xmlsoap.org/wsdl/"
  targetNamespace="' . $CFG->wwwroot . '/wspp/wsdl">
  <types>
    <xsd:schema targetNamespace="' . $CFG->wwwroot . '/wspp/wsdl">
      <xsd:import namespace="http://schemas.xmlsoap.org/soap/encoding/" />
      <xsd:import namespace="http://schemas.xmlsoap.org/wsdl/" />
      <xsd:complexType name="userRecord">
        <xsd:all>
          <xsd:element name="error" type="xsd:string" />
          <xsd:element name="id" type="xsd:integer" />  <xsd:element name="auth" type="xsd:string" />
          <xsd:element name="confirmed" type="xsd:integer" />
          <xsd:element name="policyagreed" type="xsd:integer" />
          <xsd:element name="deleted" type="xsd:integer" />
          <xsd:element name="username" type="xsd:string" />
          <xsd:element name="idnumber" type="xsd:string" />
          <xsd:element name="firstname" type="xsd:string" />
          <xsd:element name="lastname" type="xsd:string" />
          <xsd:element name="email" type="xsd:string" />
          <xsd:element name="icq" type="xsd:string" />  <xsd:element name="emailstop" type="xsd:integer" />
          <xsd:element name="skype" type="xsd:string" />
          <xsd:element name="yahoo" type="xsd:string" />
          <xsd:element name="aim" type="xsd:string" />
          <xsd:element name="msn" type="xsd:string" />
          <xsd:element name="phone1" type="xsd:string" />
          <xsd:element name="phone2" type="xsd:string" />
          <xsd:element name="institution" type="xsd:string" />
          <xsd:element name="department" type="xsd:string" />
          <xsd:element name="address" type="xsd:string" />
          <xsd:element name="city" type="xsd:string" />
          <xsd:element name="country" type="xsd:string" />
          <xsd:element name="lang" type="xsd:string" />
          <xsd:element name="timezone" type="xsd:integer" />  <xsd:element name="mnethostid" type="xsd:integer" />
          <xsd:element name="lastip" type="xsd:string" /> <xsd:element name="theme" type="xsd:string" />

          <xsd:element name="description" type="xsd:string" nillable="true" />
          <xsd:element name="role" type="xsd:integer" />
        </xsd:all>
      </xsd:complexType>
      <xsd:complexType name="groupRecord">
        <xsd:all>
          <xsd:element name="error" type="xsd:string" />
          <xsd:element name="id" type="xsd:integer" />
          <xsd:element name="courseid" type="xsd:integer" />
          <xsd:element name="name" type="xsd:string" />
          <xsd:element name="description" type="xsd:string" />
	  <xsd:element name="lang" type="xsd:string" />
	  <xsd:element name="theme" type="xsd:string" />
	  <xsd:element name="picture" type="xsd:integer"/>
	  <xsd:element name="hidepicture" type="xsd:integer"/>
	  <xsd:element name="timecreated" type="xsd:integer" />
	  <xsd:element name="timemodified" type="xsd:integer" />
      <xsd:element name="enrolmentkey" type="xsd:string" />
       </xsd:all>
      </xsd:complexType>
<xsd:complexType name="sectionRecord">
        <xsd:all>
          <xsd:element name="error" type="xsd:string" />
          <xsd:element name="id" type="xsd:integer" />
          <xsd:element name="course" type="xsd:integer" />
          <xsd:element name="section" type="xsd:integer" />
          <xsd:element name="sequence" type="xsd:string" />
	  <xsd:element name="summary" type="xsd:string" />
	  <xsd:element name="visible" type="xsd:integer" />
       </xsd:all>
      </xsd:complexType>

      <xsd:complexType name="courseRecord">
        <xsd:all>
          <xsd:element name="error" type="xsd:string" />
          <xsd:element name="id" type="xsd:integer" />
          <xsd:element name="category" type="xsd:integer" />
          <xsd:element name="sortorder" type="xsd:integer" />
          <xsd:element name="password" type="xsd:string" />
          <xsd:element name="fullname" type="xsd:string" />
          <xsd:element name="shortname" type="xsd:string" />
          <xsd:element name="idnumber" type="xsd:string" />
          <xsd:element name="summary" type="xsd:string" />
          <xsd:element name="format" type="xsd:string" />
          <xsd:element name="showgrades" type="xsd:integer" />
          <xsd:element name="newsitems" type="xsd:integer" />
          <xsd:element name="teacher" type="xsd:string" />
          <xsd:element name="teachers" type="xsd:string" />
          <xsd:element name="student" type="xsd:string" />
          <xsd:element name="students" type="xsd:string" />
          <xsd:element name="guest" type="xsd:integer" />
          <xsd:element name="startdate" type="xsd:integer" />
          <xsd:element name="enrolperiod" type="xsd:integer" />
          <xsd:element name="numsections" type="xsd:integer" />
          <xsd:element name="marker" type="xsd:integer" />
          <xsd:element name="maxbytes" type="xsd:integer" />
          <xsd:element name="visible" type="xsd:integer" />
          <xsd:element name="hiddensections" type="xsd:integer" />
          <xsd:element name="groupmode" type="xsd:integer" />
          <xsd:element name="groupmodeforce" type="xsd:integer" />
          <xsd:element name="lang" type="xsd:string" />
          <xsd:element name="theme" type="xsd:string" />
          <xsd:element name="cost" type="xsd:string" />
          <xsd:element name="timecreated" type="xsd:integer" />
          <xsd:element name="timemodified" type="xsd:integer" />
          <xsd:element name="metacourse" type="xsd:integer" /> <xsd:element name="myrole" type="xsd:integer" />
        </xsd:all>
      </xsd:complexType>
       <xsd:complexType name="userDatum">
        <xsd:all>
          <xsd:element name="action" type="xsd:string" />
          <xsd:element name="confirmed" type="xsd:integer" />
          <xsd:element name="policyagreed" type="xsd:integer" />
          <xsd:element name="deleted" type="xsd:integer" />
          <xsd:element name="username" type="xsd:string" />
	  <xsd:element name="auth" type="xsd:string" />
          <xsd:element name="password" type="xsd:string" />
          <xsd:element name="idnumber" type="xsd:string" />
          <xsd:element name="firstname" type="xsd:string" />
          <xsd:element name="lastname" type="xsd:string" />
          <xsd:element name="email" type="xsd:string" />   <xsd:element name="emailstop" type="xsd:integer" />

          <xsd:element name="icq" type="xsd:string" />
          <xsd:element name="skype" type="xsd:string" />
          <xsd:element name="yahoo" type="xsd:string" />
          <xsd:element name="aim" type="xsd:string" />
          <xsd:element name="msn" type="xsd:string" />
          <xsd:element name="phone1" type="xsd:string" />
          <xsd:element name="phone2" type="xsd:string" />
          <xsd:element name="institution" type="xsd:string" />
          <xsd:element name="department" type="xsd:string" />
          <xsd:element name="address" type="xsd:string" />
          <xsd:element name="city" type="xsd:string" />
          <xsd:element name="country" type="xsd:string" />
          <xsd:element name="lang" type="xsd:string" />
          <xsd:element name="timezone" type="xsd:integer" />
          <xsd:element name="lastip" type="xsd:string" /> <xsd:element name="theme" type="xsd:string" />

          <xsd:element name="description" type="xsd:string" />
          <xsd:element name="mnethostid" type="xsd:integer" />
        </xsd:all>
      </xsd:complexType>
       <xsd:complexType name="courseDatum">
        <xsd:all>
          <xsd:element name="action" type="xsd:string" />
          <xsd:element name="id" type="xsd:integer" />
          <xsd:element name="category" type="xsd:integer" />
          <xsd:element name="sortorder" type="xsd:integer" />
          <xsd:element name="password" type="xsd:string" />
          <xsd:element name="fullname" type="xsd:string" />
          <xsd:element name="shortname" type="xsd:string" />
          <xsd:element name="idnumber" type="xsd:string" />
          <xsd:element name="summary" type="xsd:string" />
          <xsd:element name="format" type="xsd:string" />
          <xsd:element name="showgrades" type="xsd:integer" />
          <xsd:element name="newsitems" type="xsd:integer" />
          <xsd:element name="teacher" type="xsd:string" />
          <xsd:element name="teachers" type="xsd:string" />
          <xsd:element name="student" type="xsd:string" />
          <xsd:element name="students" type="xsd:string" />
          <xsd:element name="guest" type="xsd:integer" />
          <xsd:element name="startdate" type="xsd:integer" />
          <xsd:element name="enrolperiod" type="xsd:integer" />
          <xsd:element name="numsections" type="xsd:integer" />
          <xsd:element name="marker" type="xsd:integer" />
          <xsd:element name="maxbytes" type="xsd:integer" />
          <xsd:element name="visible" type="xsd:integer" />
          <xsd:element name="hiddensections" type="xsd:integer" />
          <xsd:element name="groupmode" type="xsd:integer" />
          <xsd:element name="groupmodeforce" type="xsd:integer" />
          <xsd:element name="lang" type="xsd:string" />
          <xsd:element name="theme" type="xsd:string" />
          <xsd:element name="cost" type="xsd:string" />
          <xsd:element name="timecreated" type="xsd:integer" />
          <xsd:element name="timemodified" type="xsd:integer" />
          <xsd:element name="metacourse" type="xsd:integer" />
        </xsd:all>
      </xsd:complexType>

      <xsd:complexType name="gradeRecord">
        <xsd:all>
           <xsd:element name="error" type="xsd:string" />
           <xsd:element name="itemid" type="xsd:string" />
          <xsd:element name="grade" type="xsd:float" /> <xsd:element name="str_grade" type="xsd:string" />
            <xsd:element name="feedback" type="xsd:string" nillable="true" />
        </xsd:all>
      </xsd:complexType>


      <xsd:complexType name="enrolRecord">
        <xsd:all>  <xsd:element name="error" type="xsd:string" />
          <xsd:element name="userid" type="xsd:string" />
          <xsd:element name="course" type="xsd:string" />
          <xsd:element name="timestart" type="xsd:integer" />
          <xsd:element name="timeend" type="xsd:integer" />
          <xsd:element name="timeaccess" type="xsd:integer" />
          <xsd:element name="enrol" type="xsd:string" />
        </xsd:all>
      </xsd:complexType>

      <xsd:complexType name="eventRecord">
        <xsd:all>
          <xsd:element name="error" type="xsd:string" />
          <xsd:element name="id" type="xsd:integer" />
          <xsd:element name="name" type="xsd:string" />
          <xsd:element name="description" type="xsd:string" />
          <xsd:element name="format" type="xsd:integer" />
          <xsd:element name="courseid" type="xsd:integer" />
          <xsd:element name="groupid" type="xsd:integer" />
          <xsd:element name="userid" type="xsd:integer" />
          <xsd:element name="repeatid" type="xsd:integer" />
          <xsd:element name="modulename" type="xsd:string" />
          <xsd:element name="instance" type="xsd:integer" />
          <xsd:element name="eventtype" type="xsd:string" />
          <xsd:element name="timestart" type="xsd:integer" />
          <xsd:element name="timeduration" type="xsd:integer" />
          <xsd:element name="visible" type="xsd:integer" />
          <xsd:element name="uuid" type="xsd:string" />
          <xsd:element name="sequence" type="xsd:integer" />
          <xsd:element name="timemodified" type="xsd:integer" />
        </xsd:all>
     </xsd:complexType>

     <xsd:complexType name="changeRecord">
       <xsd:all>
          <xsd:element name="error" type="xsd:string" />
          <xsd:element name="id" type="xsd:integer" />
	  <xsd:element name="courseid" type="xsd:integer" />
          <xsd:element name="instance" type="xsd:integer" />
 	  <xsd:element name="resid" type="xsd:integer" />
          <xsd:element name="name" type="xsd:string" />
	  <xsd:element name="date" type="xsd:string" />
          <xsd:element name="timestamp" type="xsd:integer" />
	  <xsd:element name="type" type="xsd:string" />
          <xsd:element name="author" type="xsd:string" />
          <xsd:element name="link" type="xsd:string" />
          <xsd:element name="url" type="xsd:string" />
          <xsd:element name="visible" type="xsd:integer" />
        </xsd:all>
      </xsd:complexType>
      <xsd:complexType name="roleRecord">
        <xsd:all>
          <xsd:element name="error" type="xsd:string" />
          <xsd:element name="id" type="xsd:integer" />
          <xsd:element name="name" type="xsd:string" />
          <xsd:element name="shortname" type="xsd:string" />
          <xsd:element name="description" type="xsd:string" />
          <xsd:element name="sortorder" type="xsd:integer" />
        </xsd:all>
      </xsd:complexType>
      <xsd:complexType name="categoryRecord">
        <xsd:all>
	  <xsd:element name="error" type="xsd:string" />
          <xsd:element name="id" type="xsd:integer" />
          <xsd:element name="name" type="xsd:string" />
          <xsd:element name="description" type="xsd:string"  nillable="true"/>
          <xsd:element name="parent" type="xsd:integer" />
          <xsd:element name="sortorder" type="xsd:integer" />
          <xsd:element name="coursecount" type="xsd:integer" />
          <xsd:element name="visible" type="xsd:integer" />
          <xsd:element name="timemodified" type="xsd:integer" />
          <xsd:element name="depth" type="xsd:integer" />
          <xsd:element name="path" type="xsd:string" />
        </xsd:all>
      </xsd:complexType>

     <xsd:complexType name="resourceRecord">
       <xsd:all>
	  <xsd:element name="error" type="xsd:string" />
          <xsd:element name="id" type="xsd:integer" />
          <xsd:element name="name" type="xsd:string" />
          <xsd:element name="course" type="xsd:integer" />
          <xsd:element name="type" type="xsd:string" />
          <xsd:element name="reference" type="xsd:string" />
          <xsd:element name="summary" type="xsd:string" />
          <xsd:element name="alltext" type="xsd:string" />
          <xsd:element name="popup" type="xsd:string" />
	  <xsd:element name="options" type="xsd:string" />
          <xsd:element name="timemodified" type="xsd:integer" />
          <xsd:element name="section" type="xsd:integer" />
	  <xsd:element name="visible" type="xsd:integer" />
          <xsd:element name="groupmode" type="xsd:integer" />
          <xsd:element name="coursemodule" type="xsd:integer" />
	  <xsd:element name="url" type="xsd:string" />
          <xsd:element name="timemodified_ut" type="xsd:string" />
      </xsd:all>
      </xsd:complexType>


     <xsd:complexType name="resourceRecords">
        <xsd:complexContent>
          <xsd:restriction base="SOAP-ENC:Array">
            <xsd:attribute ref="SOAP-ENC:arrayType"
              wsdl:arrayType="tns:resourceRecord[]" />
          </xsd:restriction>
        </xsd:complexContent>
      </xsd:complexType>

<xsd:complexType name="sectionRecords">
        <xsd:complexContent>
          <xsd:restriction base="SOAP-ENC:Array">
            <xsd:attribute ref="SOAP-ENC:arrayType"
              wsdl:arrayType="tns:sectionRecord[]" />
          </xsd:restriction>
        </xsd:complexContent>
      </xsd:complexType>

      <xsd:complexType name="userRecords">
        <xsd:complexContent>
          <xsd:restriction base="SOAP-ENC:Array">
            <xsd:attribute ref="SOAP-ENC:arrayType"
              wsdl:arrayType="tns:userRecord[]" />
          </xsd:restriction>
        </xsd:complexContent>
      </xsd:complexType>

   <xsd:complexType name="groupRecords">
        <xsd:complexContent>
          <xsd:restriction base="SOAP-ENC:Array">
            <xsd:attribute ref="SOAP-ENC:arrayType"
              wsdl:arrayType="tns:groupRecord[]" />
          </xsd:restriction>
        </xsd:complexContent>
      </xsd:complexType>

      <xsd:complexType name="userData">
        <xsd:complexContent>
          <xsd:restriction base="SOAP-ENC:Array">
            <xsd:attribute ref="SOAP-ENC:arrayType"
              wsdl:arrayType="tns:userDatum[]" />
          </xsd:restriction>
        </xsd:complexContent>
      </xsd:complexType>

      <xsd:complexType name="courseRecords">
        <xsd:complexContent>
          <xsd:restriction base="SOAP-ENC:Array">
            <xsd:attribute ref="SOAP-ENC:arrayType"
              wsdl:arrayType="tns:courseRecord[]" />
          </xsd:restriction>
        </xsd:complexContent>
      </xsd:complexType>

      <xsd:complexType name="courseData">
        <xsd:complexContent>
          <xsd:restriction base="SOAP-ENC:Array">
            <xsd:attribute ref="SOAP-ENC:arrayType"
              wsdl:arrayType="tns:courseDatum[]" />
          </xsd:restriction>
        </xsd:complexContent>
      </xsd:complexType>

      <xsd:complexType name="gradeRecords">
        <xsd:complexContent>
          <xsd:restriction base="SOAP-ENC:Array">
            <xsd:attribute ref="SOAP-ENC:arrayType"
              wsdl:arrayType="tns:gradeRecord[]" />
          </xsd:restriction>
        </xsd:complexContent>
      </xsd:complexType>


      <xsd:complexType name="enrolRecords">
        <xsd:complexContent>
          <xsd:restriction base="SOAP-ENC:Array">
            <xsd:attribute ref="SOAP-ENC:arrayType"
              wsdl:arrayType="tns:enrolRecord[]" />
          </xsd:restriction>
        </xsd:complexContent>
      </xsd:complexType>
      <xsd:complexType name="roleRecords">
        <xsd:complexContent>
          <xsd:restriction base="SOAP-ENC:Array">
            <xsd:attribute ref="SOAP-ENC:arrayType"
              wsdl:arrayType="tns:roleRecord[]" />
          </xsd:restriction>
        </xsd:complexContent>
      </xsd:complexType>
       <xsd:complexType name="eventRecords">
        <xsd:complexContent>
          <xsd:restriction base="SOAP-ENC:Array">
            <xsd:attribute ref="SOAP-ENC:arrayType"
              wsdl:arrayType="tns:eventRecord[]" />
          </xsd:restriction>
        </xsd:complexContent>
      </xsd:complexType>
       <xsd:complexType name="categoryRecords">
        <xsd:complexContent>
          <xsd:restriction base="SOAP-ENC:Array">
            <xsd:attribute ref="SOAP-ENC:arrayType"
              wsdl:arrayType="tns:categoryRecord[]" />
          </xsd:restriction>
        </xsd:complexContent>
      </xsd:complexType>

      <xsd:complexType name="changeRecords">
        <xsd:complexContent>
          <xsd:restriction base="SOAP-ENC:Array">
            <xsd:attribute ref="SOAP-ENC:arrayType"
              wsdl:arrayType="tns:changeRecord[]" />
          </xsd:restriction>
        </xsd:complexContent>
      </xsd:complexType>

      <xsd:complexType name="loginReturn">
        <xsd:all>
          <xsd:element name="client" type="xsd:integer" />
          <xsd:element name="sessionkey" type="xsd:string" />
        </xsd:all>
      </xsd:complexType>

      <xsd:complexType name="editUsersInput">
        <xsd:all>
          <xsd:element name="users" type="tns:userData" />
        </xsd:all>
      </xsd:complexType>

      <xsd:complexType name="editUsersOutput">
        <xsd:all>
          <xsd:element name="users" type="tns:userRecords" />
        </xsd:all>
      </xsd:complexType>
      <xsd:complexType name="getUsersInput">
        <xsd:complexContent>
          <xsd:restriction base="SOAP-ENC:Array">
            <xsd:attribute ref="SOAP-ENC:arrayType"
              wsdl:arrayType="xsd:string[]" />
          </xsd:restriction>
        </xsd:complexContent>
      </xsd:complexType>

      <xsd:complexType name="getUsersReturn">
        <xsd:all>
          <xsd:element name="users" type="tns:userRecords" />
        </xsd:all>
      </xsd:complexType>
      <xsd:complexType name="editCoursesInput">
        <xsd:all>
          <xsd:element name="courses" type="tns:courseData" />
        </xsd:all>
      </xsd:complexType>
      <xsd:complexType name="editCoursesOutput">
        <xsd:all>
          <xsd:element name="courses" type="tns:courseRecords" />
        </xsd:all>
      </xsd:complexType>

     <xsd:complexType name="getCoursesInput">
        <xsd:complexContent>
          <xsd:restriction base="SOAP-ENC:Array">
            <xsd:attribute ref="SOAP-ENC:arrayType"
              wsdl:arrayType="xsd:string[]" />
          </xsd:restriction>
        </xsd:complexContent>
      </xsd:complexType>

      <xsd:complexType name="getCoursesReturn">
        <xsd:all>
          <xsd:element name="courses" type="tns:courseRecords" />
        </xsd:all>
      </xsd:complexType>



      <xsd:complexType name="getGradesReturn">
        <xsd:all>
          <xsd:element name="grades" type="tns:gradeRecords" />
        </xsd:all>
      </xsd:complexType>

      <xsd:complexType name="enrolStudentsInput">
        <xsd:complexContent>
          <xsd:restriction base="SOAP-ENC:Array">
            <xsd:attribute ref="SOAP-ENC:arrayType"
              wsdl:arrayType="xsd:string[]" />
          </xsd:restriction>
        </xsd:complexContent>
      </xsd:complexType>


      <xsd:complexType name="enrolStudentsReturn">
        <xsd:all>
          <xsd:element name="students" type="tns:enrolRecords" />
        </xsd:all>
      </xsd:complexType>

      <xsd:complexType name="getRolesReturn">
        <xsd:all>
          <xsd:element name="roles" type="tns:roleRecords" />
        </xsd:all>
      </xsd:complexType>

      <xsd:complexType name="getGroupsReturn">
        <xsd:all>
          <xsd:element name="groups" type="tns:groupRecords" />
        </xsd:all>
      </xsd:complexType>

      <xsd:complexType name="getEventsReturn">
        <xsd:all>
          <xsd:element name="events" type="tns:eventRecords" />
        </xsd:all>
      </xsd:complexType>

      <xsd:complexType name="getLastChangesReturn">
        <xsd:all>
          <xsd:element name="changes" type="tns:changeRecords" />
        </xsd:all>
      </xsd:complexType>


      <xsd:complexType name="getCategoriesReturn">
        <xsd:all>
          <xsd:element name="categories" type="tns:categoryRecords" />
        </xsd:all>
      </xsd:complexType>

 <xsd:complexType name="getResourcesReturn">
        <xsd:all>
          <xsd:element name="resources" type="tns:resourceRecords" />
        </xsd:all>
      </xsd:complexType>

 <xsd:complexType name="getSectionsReturn">
        <xsd:all>
          <xsd:element name="sections" type="tns:sectionRecords" />
        </xsd:all>
      </xsd:complexType>

   <xsd:complexType name="activityRecord">
        <xsd:all>
          <xsd:element name="error" type="xsd:string" />
          <xsd:element name="id" type="xsd:integer" />
          <xsd:element name="time" type="xsd:integer" />
          <xsd:element name="userid" type="xsd:integer" />
          <xsd:element name="ip" type="xsd:string" />
          <xsd:element name="course" type="xsd:integer" />
          <xsd:element name="module" type="xsd:integer" />
          <xsd:element name="cmid" type="xsd:integer" />
          <xsd:element name="action" type="xsd:string" />
          <xsd:element name="url" type="xsd:string" />
          <xsd:element name="info" type="xsd:string" />
          <xsd:element name="DATE" type="xsd:string" />
          <xsd:element name="auth" type="xsd:string" />
          <xsd:element name="firstname" type="xsd:string" />
          <xsd:element name="lastname" type="xsd:string" />
          <xsd:element name="email" type="xsd:string" />
          <xsd:element name="firstaccess" type="xsd:integer" />
          <xsd:element name="lastaccess" type="xsd:integer" />
          <xsd:element name="lastlogin" type="xsd:integer" />
          <xsd:element name="currentlogin" type="xsd:integer" />
          <xsd:element name="DLA" type="xsd:string" />
          <xsd:element name="DFA" type="xsd:string" />
          <xsd:element name="DLL" type="xsd:string" />
          <xsd:element name="DCL" type="xsd:string" />
        </xsd:all>
      </xsd:complexType>



     <xsd:complexType name="activityRecords">
        <xsd:complexContent>
          <xsd:restriction base="SOAP-ENC:Array">
            <xsd:attribute ref="SOAP-ENC:arrayType"
              wsdl:arrayType="tns:activityRecord[]" />
          </xsd:restriction>
        </xsd:complexContent>
      </xsd:complexType>


     <xsd:complexType name="getActivitiesReturn">
        <xsd:all>
          <xsd:element name="activities" type="tns:activityRecords" />
        </xsd:all>
      </xsd:complexType>

            <!-- TYPES FROM LILLE -->

          <!-- general -->

              <xsd:complexType name="affectRecord">
                <xsd:all>
                  <xsd:element name="error" type="xsd:string" />
                  <xsd:element name="status" type="xsd:boolean" />
                </xsd:all>
              </xsd:complexType>

          <!-- /general -->

        <!-- edit_labels -->
              <xsd:complexType name="editLabelsInput">
                <xsd:all>
                  <xsd:element name="labels" type="tns:labelData" />
                </xsd:all>
              </xsd:complexType>
              <xsd:complexType name="labelData">
                <xsd:complexContent>
                  <xsd:restriction base="SOAP-ENC:Array">
                    <xsd:attribute ref="SOAP-ENC:arrayType"
                      wsdl:arrayType="tns:labelDatum[]" />
                  </xsd:restriction>
                </xsd:complexContent>
              </xsd:complexType>
              <xsd:complexType name="labelDatum">
                <xsd:all>
                  <xsd:element name="action" type="xsd:string" />
                  <xsd:element name="id" type="xsd:integer" />
                  <xsd:element name="course" type="xsd:integer" />
                  <xsd:element name="name" type="xsd:string" />
                  <xsd:element name="content" type="xsd:string" />
                  <xsd:element name="timemodified" type="xsd:integer" />
                </xsd:all>
              </xsd:complexType>
              <xsd:complexType name="editLabelsOutput">
                <xsd:all>
                  <xsd:element name="labels" type="tns:labelRecords" />
                </xsd:all>
              </xsd:complexType>
               <xsd:complexType name="labelRecords">
                <xsd:complexContent>
                  <xsd:restriction base="SOAP-ENC:Array">
                    <xsd:attribute ref="SOAP-ENC:arrayType"
                      wsdl:arrayType="tns:labelRecord[]" />
                  </xsd:restriction>
                </xsd:complexContent>
              </xsd:complexType>
              <xsd:complexType name="labelRecord">
                <xsd:all>
                  <xsd:element name="error" type="xsd:string" />
                  <xsd:element name="id" type="xsd:integer" />
                  <xsd:element name="course" type="xsd:integer" />
                  <xsd:element name="name" type="xsd:string" />
                  <xsd:element name="content" type="xsd:string" />
                  <xsd:element name="timemodified" type="xsd:integer" />
                </xsd:all>
              </xsd:complexType>
          <!-- /edit_labels -->

          <!-- edit_groups -->
              <xsd:complexType name="editGroupsInput">
                <xsd:all>
                  <xsd:element name="groups" type="tns:groupData" />
                </xsd:all>
              </xsd:complexType>
              <xsd:complexType name="groupData">
                <xsd:complexContent>
                  <xsd:restriction base="SOAP-ENC:Array">
                    <xsd:attribute ref="SOAP-ENC:arrayType"
                      wsdl:arrayType="tns:groupDatum[]" />
                  </xsd:restriction>
                </xsd:complexContent>
              </xsd:complexType>
              <xsd:complexType name="groupDatum">
                <xsd:all>
                  <xsd:element name="action" type="xsd:string" />
                  <xsd:element name="id" type="xsd:integer" />
                  <xsd:element name="courseid" type="xsd:integer" />
                  <xsd:element name="name" type="xsd:string" />
                  <xsd:element name="description" type="xsd:string" />
                  <xsd:element name="enrolmentkey" type="xsd:string" />
                  <xsd:element name="picture" type="xsd:integer"/>
                  <xsd:element name="hidepicture" type="xsd:integer"/>
                  <xsd:element name="timecreated" type="xsd:integer" />
                  <xsd:element name="timemodified" type="xsd:integer" />
                </xsd:all>
              </xsd:complexType>
              <xsd:complexType name="editGroupsOutput">
                <xsd:all>
                  <xsd:element name="groups" type="tns:groupRecords" />
                </xsd:all>
              </xsd:complexType>
             <xsd:complexType name="groupRecords">
                <xsd:complexContent>
                  <xsd:restriction base="SOAP-ENC:Array">
                    <xsd:attribute ref="SOAP-ENC:arrayType"
                      wsdl:arrayType="tns:groupRecord[]" />
                  </xsd:restriction>
                </xsd:complexContent>
              </xsd:complexType>
              <xsd:complexType name="groupRecord">
                <xsd:all>
                  <xsd:element name="error" type="xsd:string" />
                  <xsd:element name="id" type="xsd:integer" />
                  <xsd:element name="courseid" type="xsd:integer" />
                  <xsd:element name="name" type="xsd:string" />
                  <xsd:element name="description" type="xsd:string" />
                  <xsd:element name="enrolmentkey" type="xsd:string" />
                  <xsd:element name="picture" type="xsd:integer"/>
                  <xsd:element name="hidepicture" type="xsd:integer"/>
                  <xsd:element name="timecreated" type="xsd:integer" />
                  <xsd:element name="timemodified" type="xsd:integer" />
                </xsd:all>
              </xsd:complexType>

          <!-- edit_groups -->

          <!-- edit_categories -->
              <xsd:complexType name="editCategoriesInput">
                <xsd:all>
                  <xsd:element name="categories" type="tns:categoryData" />
                </xsd:all>
              </xsd:complexType>
              <xsd:complexType name="categoryData">
                <xsd:complexContent>
                  <xsd:restriction base="SOAP-ENC:Array">
                    <xsd:attribute ref="SOAP-ENC:arrayType"
                      wsdl:arrayType="tns:categoryDatum[]" />
                  </xsd:restriction>
                </xsd:complexContent>
              </xsd:complexType>
              <xsd:complexType name="categoryDatum">
                <xsd:all>
                  <xsd:element name="action" type="xsd:string" />
                  <xsd:element name="id" type="xsd:integer" />
                  <xsd:element name="name" type="xsd:string" />
                  <xsd:element name="description" type="xsd:string" />
                  <xsd:element name="parent" type="xsd:integer" />
                  <xsd:element name="sortorder" type="xsd:integer" />
                  <xsd:element name="coursecount" type="xsd:integer" />
                  <xsd:element name="visible" type="xsd:integer" />
                  <xsd:element name="timemodified" type="xsd:integer" />
                  <xsd:element name="depth" type="xsd:integer" />
                  <xsd:element name="path" type="xsd:string" />
                  <xsd:element name="theme" type="xsd:string" />
                </xsd:all>
              </xsd:complexType>
              <xsd:complexType name="editCategoriesOutput">
                <xsd:all>
                  <xsd:element name="categories" type="tns:categoryRecords" />
                </xsd:all>
              </xsd:complexType>
          <!-- /edit_categories -->



          <!-- edit_sections -->
              <xsd:complexType name="editSectionsInput">
                <xsd:all>
                  <xsd:element name="sections" type="tns:sectionData" />
                </xsd:all>
              </xsd:complexType>
              <xsd:complexType name="sectionData">
                <xsd:complexContent>
                  <xsd:restriction base="SOAP-ENC:Array">
                    <xsd:attribute ref="SOAP-ENC:arrayType"
                      wsdl:arrayType="tns:sectionDatum[]" />
                  </xsd:restriction>
                </xsd:complexContent>
              </xsd:complexType>
              <xsd:complexType name="sectionDatum">
                <xsd:all>
                  <xsd:element name="action" type="xsd:string" />
                  <xsd:element name="id" type="xsd:integer" />
                  <xsd:element name="course" type="xsd:integer" />
                  <xsd:element name="section" type="xsd:integer" />
                  <xsd:element name="summary" type="xsd:string" />
                  <xsd:element name="sequence" type="xsd:string" />
                  <xsd:element name="visible" type="xsd:integer" />
                </xsd:all>
              </xsd:complexType>
              <xsd:complexType name="editSectionsOutput">
                <xsd:all>
                  <xsd:element name="sections" type="tns:sectionRecords" />
                </xsd:all>
              </xsd:complexType>
          <!-- /edit_sections -->

          <!-- edit_forums -->
              <xsd:complexType name="editForumsInput">
                <xsd:all>
                  <xsd:element name="forums" type="tns:forumData" />
                </xsd:all>
              </xsd:complexType>
              <xsd:complexType name="forumData">
                <xsd:complexContent>
                  <xsd:restriction base="SOAP-ENC:Array">
                    <xsd:attribute ref="SOAP-ENC:arrayType"
                      wsdl:arrayType="tns:forumDatum[]" />
                  </xsd:restriction>
                </xsd:complexContent>
              </xsd:complexType>
              <xsd:complexType name="forumDatum">
                <xsd:all>
                  <xsd:element name="action" type="xsd:string" />
                  <xsd:element name="id" type="xsd:integer" />
                  <xsd:element name="course" type="xsd:integer" />
                  <xsd:element name="type" type="xsd:string" />
                  <xsd:element name="name" type="xsd:string" />
                  <xsd:element name="intro" type="xsd:string" />
                  <xsd:element name="assessed" type="xsd:integer" />
                  <xsd:element name="assesstimestart" type="xsd:integer" />
                  <xsd:element name="assesstimefinish" type="xsd:integer" />
                  <xsd:element name="scale" type="xsd:integer" />
                  <xsd:element name="maxbytes" type="xsd:integer" />
                  <xsd:element name="forcesubscribe" type="xsd:integer" />
                  <xsd:element name="trackingtype" type="xsd:integer" />
                  <xsd:element name="rsstype" type="xsd:integer" />
                  <xsd:element name="rssarticles" type="xsd:integer" />
                  <xsd:element name="timemodified" type="xsd:integer" />
                  <xsd:element name="warnafter" type="xsd:integer" />
                  <xsd:element name="blockafter" type="xsd:integer" />
                  <xsd:element name="blockperiod" type="xsd:integer" />
                </xsd:all>
              </xsd:complexType>
              <xsd:complexType name="editForumsOutput">
                <xsd:all>
                  <xsd:element name="forums" type="tns:forumRecords" />
                </xsd:all>
              </xsd:complexType>
               <xsd:complexType name="forumRecords">
                <xsd:complexContent>
                  <xsd:restriction base="SOAP-ENC:Array">
                    <xsd:attribute ref="SOAP-ENC:arrayType"
                      wsdl:arrayType="tns:forumRecord[]" />
                  </xsd:restriction>
                </xsd:complexContent>
              </xsd:complexType>
              <xsd:complexType name="forumRecord">
                <xsd:all>
                  <xsd:element name="error" type="xsd:string" />
                  <xsd:element name="id" type="xsd:integer" />
                  <xsd:element name="course" type="xsd:integer" />
                  <xsd:element name="type" type="xsd:string" />
                  <xsd:element name="name" type="xsd:string" />
                  <xsd:element name="intro" type="xsd:string" />
                  <xsd:element name="assessed" type="xsd:integer" />
                  <xsd:element name="assesstimestart" type="xsd:integer" />
                  <xsd:element name="assesstimefinish" type="xsd:integer" />
                  <xsd:element name="scale" type="xsd:integer" />
                  <xsd:element name="maxbytes" type="xsd:integer" />
                  <xsd:element name="forcesubscribe" type="xsd:integer" />
                  <xsd:element name="trackingtype" type="xsd:integer" />
                  <xsd:element name="rsstype" type="xsd:integer" />
                  <xsd:element name="rssarticles" type="xsd:integer" />
                  <xsd:element name="timemodified" type="xsd:integer" />
                  <xsd:element name="warnafter" type="xsd:integer" />
                  <xsd:element name="blockafter" type="xsd:integer" />
                  <xsd:element name="blockperiod" type="xsd:integer" />
                </xsd:all>
              </xsd:complexType>
          <!-- /edit_forums -->

          <!-- edit_assignment -->
            <xsd:complexType name="editAssignmentsInput">
                <xsd:all>
                  <xsd:element name="assignments" type="tns:assignmentData" />
                </xsd:all>
             </xsd:complexType>
            <xsd:complexType name="assignmentData">
                <xsd:complexContent>
                  <xsd:restriction base="SOAP-ENC:Array">
                    <xsd:attribute ref="SOAP-ENC:arrayType"
                      wsdl:arrayType="tns:assignmentDatum[]" />
                  </xsd:restriction>
                </xsd:complexContent>
            </xsd:complexType>
            <xsd:complexType name="assignmentDatum">
                <xsd:all>
                  <xsd:element name="action" type="xsd:string" />
                  <xsd:element name="id" type="xsd:integer" />
                  <xsd:element name="course" type="xsd:integer" />
                  <xsd:element name="name" type="xsd:string" />
                  <xsd:element name="description" type="xsd:string" />
                  <xsd:element name="format" type="xsd:integer" />
                  <xsd:element name="assignmenttype" type="xsd:string"/>
                  <xsd:element name="resubmit" type="xsd:integer" />
                  <xsd:element name="preventlate" type="xsd:integer" />
                  <xsd:element name="emailteachers" type="xsd:integer" />
                  <xsd:element name="var1" type="xsd:integer" />
                  <xsd:element name="var2" type="xsd:integer" />
                  <xsd:element name="var3" type="xsd:integer" />
                  <xsd:element name="var4" type="xsd:integer" />
                  <xsd:element name="var5" type="xsd:integer" />
                  <xsd:element name="maxbytes" type="xsd:integer" />
                  <xsd:element name="timedue" type="xsd:integer" />
                  <xsd:element name="timeavailable" type="xsd:integer" />
                  <xsd:element name="grade" type="xsd:integer" />
                  <xsd:element name="timemodified" type="xsd:integer" />
                </xsd:all>
              </xsd:complexType>
             <xsd:complexType name="editAssignmentsOutput">
                <xsd:all>
                  <xsd:element name="assignments" type="tns:assignmentRecords" />
                </xsd:all>
             </xsd:complexType>
             <xsd:complexType name="assignmentRecords">
                <xsd:complexContent>
                  <xsd:restriction base="SOAP-ENC:Array">
                    <xsd:attribute ref="SOAP-ENC:arrayType"
                      wsdl:arrayType="tns:assignmentRecord[]" />
                  </xsd:restriction>
                </xsd:complexContent>
              </xsd:complexType>
              <xsd:complexType name="assignmentRecord">
                <xsd:all>
                  <xsd:element name="error" type="xsd:string" />
                  <xsd:element name="id" type="xsd:integer" />
                  <xsd:element name="course" type="xsd:integer" />
                  <xsd:element name="name" type="xsd:string" />
                  <xsd:element name="description" type="xsd:string" />
                  <xsd:element name="format" type="xsd:integer" />
                  <xsd:element name="assignmenttype" type="xsd:string"/>
                  <xsd:element name="resubmit" type="xsd:integer" />
                  <xsd:element name="preventlate" type="xsd:integer" />
                  <xsd:element name="emailteachers" type="xsd:integer" />
                  <xsd:element name="var1" type="xsd:integer" />
                  <xsd:element name="var2" type="xsd:integer" />
                  <xsd:element name="var3" type="xsd:integer" />
                  <xsd:element name="var4" type="xsd:integer" />
                  <xsd:element name="var5" type="xsd:integer" />
                  <xsd:element name="maxbytes" type="xsd:integer" />
                  <xsd:element name="timedue" type="xsd:integer" />
                  <xsd:element name="timeavailable" type="xsd:integer" />
                  <xsd:element name="grade" type="xsd:integer" />
                  <xsd:element name="timemodified" type="xsd:integer" />
                </xsd:all>
              </xsd:complexType>
          <!-- /edit_assignment -->

          <!-- edit_databases -->
          <xsd:complexType name="editDatabasesInput">
            <xsd:all>
              <xsd:element name="databases" type="tns:databaseData" />
            </xsd:all>
          </xsd:complexType>
            <xsd:complexType name="databaseData">
                <xsd:complexContent>
                  <xsd:restriction base="SOAP-ENC:Array">
                    <xsd:attribute ref="SOAP-ENC:arrayType"
                      wsdl:arrayType="tns:databaseDatum[]" />
                  </xsd:restriction>
                </xsd:complexContent>
            </xsd:complexType>
            <xsd:complexType name="databaseDatum">
                <xsd:all>
                  <xsd:element name="action" type="xsd:string" />
                  <xsd:element name="id" type="xsd:integer" />
                  <xsd:element name="course" type="xsd:integer" />
                  <xsd:element name="name" type="xsd:string" />
                  <xsd:element name="intro" type="xsd:string" />
                  <xsd:element name="comments" type="xsd:integer" />
                  <xsd:element name="timeavailablefrom" type="xsd:integer" />
                  <xsd:element name="timeavailableto" type="xsd:integer"/>
                  <xsd:element name="timeviewfrom" type="xsd:integer" />
                  <xsd:element name="timeviewto" type="xsd:integer" />
                  <xsd:element name="requiredentries" type="xsd:integer" />
                  <xsd:element name="requiredentriestoview" type="xsd:integer" />
                  <xsd:element name="maxentries" type="xsd:integer" />
                  <xsd:element name="ressarticles" type="xsd:integer" />
                  <xsd:element name="singletemplate" type="xsd:string" />
                  <xsd:element name="listtemplate" type="xsd:string" />
                  <xsd:element name="listtemplateheader" type="xsd:string" />
                  <xsd:element name="listtemplatefooter" type="xsd:string" />
                  <xsd:element name="addtemplatee" type="xsd:string" />
                  <xsd:element name="rsstemplate" type="xsd:string" />
                  <xsd:element name="rsstitletemplate" type="xsd:string" />
                  <xsd:element name="csstemplate" type="xsd:string" />
                  <xsd:element name="jstemplate" type="xsd:string" />
                  <xsd:element name="asearchtemplate" type="xsd:string" />
                  <xsd:element name="approval" type="xsd:integer" />
                  <xsd:element name="scale" type="xsd:integer" />
                  <xsd:element name="assessed" type="xsd:integer" />
                  <xsd:element name="defaultsort" type="xsd:integer" />
                  <xsd:element name="defaultsortdir" type="xsd:integer" />
                  <xsd:element name="editany" type="xsd:integer" />
                  <xsd:element name="notification" type="xsd:integer" />
                </xsd:all>
              </xsd:complexType>
              <xsd:complexType name="editDatabasesOutput">
                <xsd:all>
                  <xsd:element name="databases" type="tns:databaseRecords" />
                </xsd:all>
              </xsd:complexType>
              <xsd:complexType name="databaseRecords">
                <xsd:complexContent>
                  <xsd:restriction base="SOAP-ENC:Array">
                    <xsd:attribute ref="SOAP-ENC:arrayType"
                      wsdl:arrayType="tns:databaseRecord[]" />
                  </xsd:restriction>
                </xsd:complexContent>
              </xsd:complexType>
              <xsd:complexType name="databaseRecord">
                <xsd:all>
                  <xsd:element name="error" type="xsd:string" />
                  <xsd:element name="id" type="xsd:integer" />
                  <xsd:element name="course" type="xsd:integer" />
                  <xsd:element name="name" type="xsd:string" />
                  <xsd:element name="intro" type="xsd:string" />
                  <xsd:element name="comments" type="xsd:integer" />
                  <xsd:element name="timeavailablefrom" type="xsd:integer" />
                  <xsd:element name="timeavailableto" type="xsd:integer"/>
                  <xsd:element name="timeviewfrom" type="xsd:integer" />
                  <xsd:element name="timeviewto" type="xsd:integer" />
                  <xsd:element name="requiredentries" type="xsd:integer" />
                  <xsd:element name="requiredentriestoview" type="xsd:integer" />
                  <xsd:element name="maxentries" type="xsd:integer" />
                  <xsd:element name="ressarticles" type="xsd:integer" />
                  <xsd:element name="singletemplate" type="xsd:string" />
                  <xsd:element name="listtemplate" type="xsd:string" />
                  <xsd:element name="listtemplateheader" type="xsd:string" />
                  <xsd:element name="listtemplatefooter" type="xsd:string" />
                  <xsd:element name="addtemplatee" type="xsd:string" />
                  <xsd:element name="rsstemplate" type="xsd:string" />
                  <xsd:element name="rsstitletemplate" type="xsd:string" />
                  <xsd:element name="csstemplate" type="xsd:string" />
                  <xsd:element name="jstemplate" type="xsd:string" />
                  <xsd:element name="asearchtemplate" type="xsd:string" />
                  <xsd:element name="approval" type="xsd:integer" />
                  <xsd:element name="scale" type="xsd:integer" />
                  <xsd:element name="assessed" type="xsd:integer" />
                  <xsd:element name="defaultsort" type="xsd:integer" />
                  <xsd:element name="defaultsortdir" type="xsd:integer" />
                  <xsd:element name="editany" type="xsd:integer" />
                  <xsd:element name="notification" type="xsd:integer" />
                </xsd:all>
              </xsd:complexType>
          <!-- /edit_databases -->

          <!-- edit_wikis -->
          <xsd:complexType name="editWikisInput">
            <xsd:all>
              <xsd:element name="wikis" type="tns:wikiData" />
            </xsd:all>
          </xsd:complexType>
          <xsd:complexType name="wikiData">
            <xsd:complexContent>
              <xsd:restriction base="SOAP-ENC:Array">
                <xsd:attribute ref="SOAP-ENC:arrayType"
                  wsdl:arrayType="tns:wikiDatum[]" />
              </xsd:restriction>
            </xsd:complexContent>
          </xsd:complexType>
          <xsd:complexType name="wikiDatum">
            <xsd:all>
              <xsd:element name="action" type="xsd:string" />
              <xsd:element name="id" type="xsd:integer" />
              <xsd:element name="name" type="xsd:string" />
              <xsd:element name="summary" type="xsd:string" />
              <xsd:element name="wtype" type="xsd:string" />
              <xsd:element name="ewikiacceptbinary" type="xsd:integer" />
              <xsd:element name="course" type="xsd:integer" />
              <xsd:element name="pagename" type="xsd:string" />
              <xsd:element name="ewikiprinttitle" type="xsd:integer" />
              <xsd:element name="htmlmode" type="xsd:integer" />
              <xsd:element name="disablecamelcase" type="xsd:integer" />
              <xsd:element name="setpageflags" type="xsd:integer" />
              <xsd:element name="strippages" type="xsd:integer" />
              <xsd:element name="removepages" type="xsd:integer" />
              <xsd:element name="revertchanges" type="xsd:integer" />
              <xsd:element name="initialcontent" type="xsd:string" />
              <xsd:element name="timemodified" type="xsd:integer" />
            </xsd:all>
          </xsd:complexType>
          <xsd:complexType name="editWikisOutput">
            <xsd:all>
              <xsd:element name="wikis" type="tns:wikiRecords" />
            </xsd:all>
          </xsd:complexType>
          <xsd:complexType name="wikiRecords">
            <xsd:complexContent>
              <xsd:restriction base="SOAP-ENC:Array">
                <xsd:attribute ref="SOAP-ENC:arrayType"
                  wsdl:arrayType="tns:wikiRecord[]" />
              </xsd:restriction>
            </xsd:complexContent>
          </xsd:complexType>
          <xsd:complexType name="wikiRecord">
            <xsd:all>
              <xsd:element name="error" type="xsd:string" />
              <xsd:element name="id" type="xsd:integer" />
              <xsd:element name="name" type="xsd:string" />
              <xsd:element name="summary" type="xsd:string" />
              <xsd:element name="wtype" type="xsd:string" />
              <xsd:element name="ewikiacceptbinary" type="xsd:integer" />
              <xsd:element name="course" type="xsd:integer" />
              <xsd:element name="pagename" type="xsd:string" />
              <xsd:element name="ewikiprinttitle" type="xsd:integer" />
              <xsd:element name="htmlmode" type="xsd:integer" />
              <xsd:element name="disablecamelcase" type="xsd:integer" />
              <xsd:element name="setpageflags" type="xsd:integer" />
              <xsd:element name="strippages" type="xsd:integer" />
              <xsd:element name="removepages" type="xsd:integer" />
              <xsd:element name="revertchanges" type="xsd:integer" />
              <xsd:element name="initialcontent" type="xsd:string" />
              <xsd:element name="timemodified" type="xsd:integer" />
            </xsd:all>
          </xsd:complexType>
          <!-- /edit_wikis -->

          <!-- edit_pagesWiki -->
          <xsd:complexType name="editPagesWikiInput">
            <xsd:all>
              <xsd:element name="pagesWiki" type="tns:pageWikiData" />
            </xsd:all>
          </xsd:complexType>
          <xsd:complexType name="pageWikiData">
            <xsd:complexContent>
              <xsd:restriction base="SOAP-ENC:Array">
                <xsd:attribute ref="SOAP-ENC:arrayType"
                  wsdl:arrayType="tns:pageWikiDatum[]" />
              </xsd:restriction>
            </xsd:complexContent>
          </xsd:complexType>
          <xsd:complexType name="pageWikiDatum">
            <xsd:all>
              <xsd:element name="action" type="xsd:string" />
              <xsd:element name="id" type="xsd:integer" />
              <xsd:element name="pagename" type="xsd:string" />
              <xsd:element name="version" type="xsd:integer" />
              <xsd:element name="flags" type="xsd:integer" />
              <xsd:element name="content" type="xsd:string" />
              <xsd:element name="author" type="xsd:string" />
              <xsd:element name="userid" type="xsd:integer" />
              <xsd:element name="created" type="xsd:integer" />
              <xsd:element name="lastmodified" type="xsd:integer" />
              <xsd:element name="refs" type="xsd:string" />
              <xsd:element name="meta" type="xsd:string" />
              <xsd:element name="hits" type="xsd:integer" />
              <xsd:element name="wiki" type="xsd:integer" />
            </xsd:all>
          </xsd:complexType>
           <xsd:complexType name="editPagesWikiOutput">
                <xsd:all>
                  <xsd:element name="pagesWiki" type="tns:pageWikiRecords" />
                </xsd:all>
           </xsd:complexType>
           <xsd:complexType name="pageWikiRecords">
            <xsd:complexContent>
              <xsd:restriction base="SOAP-ENC:Array">
                <xsd:attribute ref="SOAP-ENC:arrayType"
                  wsdl:arrayType="tns:pageWikiRecord[]" />
              </xsd:restriction>
            </xsd:complexContent>
           </xsd:complexType>
            <xsd:complexType name="pageWikiRecord">
                <xsd:all>
                  <xsd:element name="error" type="xsd:string" />
                  <xsd:element name="id" type="xsd:integer" />

                  <xsd:element name="pagename" type="xsd:string" />
                  <xsd:element name="version" type="xsd:integer" />
                  <xsd:element name="flags" type="xsd:integer" />
                  <xsd:element name="content" type="xsd:string" />
                  <xsd:element name="author" type="xsd:string" />
                  <xsd:element name="userid" type="xsd:integer" />
                  <xsd:element name="created" type="xsd:integer" />
                  <xsd:element name="lastmodified" type="xsd:integer" />
                  <xsd:element name="refs" type="xsd:string" />
                  <xsd:element name="meta" type="xsd:string" />
                  <xsd:element name="hits" type="xsd:integer" />
                  <xsd:element name="wiki" type="xsd:integer" />
                </xsd:all>
              </xsd:complexType>
          <!-- /edit_pagesWiki -->

          <!-- get_all_forums -->
          <xsd:complexType name="getAllForumsReturn">
            <xsd:all>
              <xsd:element name="forums" type="tns:forumRecords" />
            </xsd:all>
          </xsd:complexType>
          <!-- /get_all_forums -->

          <!-- get_all_labels -->
          <xsd:complexType name="getAllLabelsReturn">
            <xsd:all>
              <xsd:element name="labels" type="tns:labelRecords" />
            </xsd:all>
          </xsd:complexType>
          <!-- /get_all_labels -->

          <!-- get_all_wikis -->
          <xsd:complexType name="getAllWikisReturn">
            <xsd:all>
              <xsd:element name="wikis" type="tns:wikiRecords" />
            </xsd:all>
          </xsd:complexType>
          <!-- /get_all_wikis -->

          <!-- get_all_pagesWiki -->
          <xsd:complexType name="getAllPagesWikiReturn">
            <xsd:all>
              <xsd:element name="pageswiki" type="tns:pageWikiRecords" />
            </xsd:all>
          </xsd:complexType>
          <!-- /get_all_pagesWiki -->

          <!-- get_all_assignments -->
          <xsd:complexType name="getAllAssignmentsReturn">
            <xsd:all>
              <xsd:element name="assignments" type="tns:assignmentRecords" />
            </xsd:all>
          </xsd:complexType>
          <!-- /get_all_assignments -->

          <!-- get_all_databases -->
          <xsd:complexType name="getAllDatabasesReturn">
            <xsd:all>
              <xsd:element name="databases" type="tns:databaseRecords" />
            </xsd:all>
          </xsd:complexType>
          <!-- /get_all_databases -->

      <!-- /TYPES FROM LILLE -->


    </xsd:schema>
  </types>


  <message name="loginRequest">
    <part name="username" type="xsd:string" />
    <part name="password" type="xsd:string" />
  </message>
  <message name="loginResponse">
    <part name="return" type="tns:loginReturn" />
  </message>
  <message name="logoutRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
  </message>
  <message name="logoutResponse">
    <part name="return" type="xsd:boolean" />
  </message>

  <message name="integerResponse">
    <part name="return" type="xsd:integer" />
  </message>

  <message name="booleanResponse">
    <part name="return" type="xsd:boolean" />
  </message>

   <message name="floatResponse">
    <part name="return" type="xsd:float" />
  </message>


  <message name="stringResponse">
    <part name="return" type="xsd:string" />
  </message>


  <message name="noinputRequest">
    <documentation> PP No further input needed </documentation>
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
  </message>

  <message name="oneValueRequest">
    <documentation>PP one value to search for </documentation>
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="value" type="xsd:string" />
  </message>

   <message name="valueAndIdRequest">
    <documentation>PP one value to search for in column id </documentation>
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="value" type="xsd:string" />
    <part name="id" type="xsd:string" />
  </message>

  <message name="twoValuesAndIdsRequest">
    <documentation>PP one value to search for in column id </documentation>
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="value1" type="xsd:string" />
    <part name="id1" type="xsd:string" />
    <part name="value2" type="xsd:string" />
    <part name="id2" type="xsd:string" />

  </message>

  <message name="edit_usersRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="users" type="tns:editUsersInput" />
  </message>

  <message name="edit_usersResponse">
    <part name="return" type="tns:editUsersOutput" />
  </message>
  <message name="get_usersRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="userids" type="tns:getUsersInput" />
    <part name="idfield" type="xsd:string" />
  </message>
  <message name="get_usersResponse">
    <part name="return" type="tns:getUsersReturn" />
  </message>

  <message name="edit_coursesRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="courses" type="tns:editCoursesInput" />
  </message>

  <message name="edit_coursesResponse">
    <part name="return" type="tns:editCoursesOutput" />
  </message>

  <message name="get_coursesRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="courseids" type="tns:getCoursesInput" />
    <part name="idfield" type="xsd:string" />
  </message>

  <message name="get_coursesResponse">
    <part name="return" type="tns:getCoursesReturn" />
  </message>

 <message name="get_resourcesResponse">
    <part name="return" type="tns:getResourcesReturn" />
  </message>

<message name="get_instances_bytypeRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="courseids" type="tns:getCoursesInput" />
    <part name="idfield" type="xsd:string" />
    <part name="type" type="xsd:string" />
  </message>



  <message name="get_groups_bycourseRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="courseid" type="xsd:string" />
    <part name="idfield" type="xsd:string" />
  </message>

  <message name="get_groupsResponse">
    <part name="return" type="tns:getGroupsReturn" />
  </message>

  <message name="get_group_membersRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="groupid" type="xsd:integer" />
  </message>




  <message name="get_courseRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="courseid" type="xsd:string" />
    <part name="idfield" type="xsd:string" />
  </message>

  <message name="get_course_byRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="info" type="xsd:string" />
  </message>

  <message name="get_group_byRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="info" type="xsd:string" />
    <part name="courseid" type="xsd:integer" />
  </message>


  <message name="get_userRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="userid" type="xsd:string" />
    <part name="idfield" type="xsd:string" />
  </message>


  <message name="get_gradesRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="userid" type="xsd:string" /><part name="userfield" type="xsd:string" />
    <part name="courseids" type="tns:getCoursesInput" />
    <part name="courseidfield" type="xsd:string" />
  </message>

  <message name="get_gradesResponse">
    <part name="return" type="tns:getGradesReturn" />
  </message>




  <message name="enrol_studentsRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="courseid" type="xsd:string" /> <part name="courseidfield" type="xsd:string" />
    <part name="userids" type="tns:enrolStudentsInput" />
    <part name="useridfield" type="xsd:string" />
  </message>
  <message name="enrol_studentsResponse">
    <part name="return" type="tns:enrolStudentsReturn" />
  </message>



  <message name="get_rolesResponse">
    <part name="return" type="tns:getRolesReturn" />
  </message>

 <message name="get_categoriesResponse">
    <part name="return" type="tns:getCategoriesReturn" />
  </message>


<message name="get_eventsRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="eventtype" type="xsd:integer" />
    <part name="ownerid" type="xsd:integer" />
  </message>

  <message name="get_eventsResponse">
    <part name="return" type="tns:getEventsReturn" />
  </message>

 <message name="get_last_changesRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="courseid" type="xsd:string" />
    <part name="idfield" type="xsd:string" />
    <part name="limit" type="xsd:integer" />
  </message>


  <message name="get_last_changesResponse">
    <part name="return" type="tns:getLastChangesReturn" />
  </message>


   <message name="get_my_coursesRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="uid" type="xsd:integer" />
    <part name="sort" type="xsd:string" />
  </message>

  <message name="get_my_courses_byRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="uinfo" type="xsd:string" />
    <part name="sort" type="xsd:string" />
  </message>

   <message name="get_my_groupRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="uid" type="xsd:integer" />
    <part name="courseid" type="xsd:integer" />
  </message>

  <message name="get_my_groupsRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="uid" type="xsd:string" /> <part name="idfield" type="xsd:string" />
  </message>


   <message name="get_courses_bycategoryRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="categoryid" type="xsd:integer" />
  </message>


  <message name="get_user_byRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="userinfo" type="xsd:string" />
  </message>

  <message name="get_users_bycourseRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="idcourse" type="xsd:string" />
    <part name="idfield" type="xsd:string" />
    <part name="idrole" type="xsd:integer" />
  </message>

   <message name="has_role_incourseRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="iduser" type="xsd:string" />
    <part name="iduserfield" type="xsd:string" />
    <part name="idcourse" type="xsd:string" />
    <part name="idcoursefield" type="xsd:string" />
    <part name="idrole" type="xsd:integer" />
  </message>

   <message name="get_primaryrole_incourseRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="iduser" type="xsd:string" />
    <part name="iduserfield" type="xsd:string" />
    <part name="idcourse" type="xsd:string" />
    <part name="idcoursefield" type="xsd:string" />
  </message>

  <message name="get_activitiesRequest">
    <part name="client" type="xsd:integer" />
    <part name="sesskey" type="xsd:string" />
    <part name="iduser" type="xsd:string" />
    <part name="iduserfield" type="xsd:string" />
    <part name="idcourse" type="xsd:string" />
    <part name="idcoursefield" type="xsd:string" />
    <part name="idlimit" type="xsd:integer" />
  </message>

  <message name="get_sectionsResponse">
    <part name="return" type="tns:getSectionsReturn" />
  </message>



  <message name="get_activitiesResponse">
    <part name="return" type="tns:getActivitiesReturn" />
  </message>


    <!-- MESSAGES FROM LILLE -->

      <!-- generics -->
             <message name="affectResponse">
               <part name="return" type="tns:affectRecord" />
             </message>
             <message name="get_genericRequest">
                <part name="client" type="xsd:integer" />
                <part name="sesskey" type="xsd:string" />
                <part name="fieldname" type="xsd:string" />
                <part name="fieldvalue" type="xsd:string" />
             </message>
      <!-- /generics -->

      <!-- /general -->

    <!-- edit_labels -->
          <message name="edit_labelsRequest">
            <part name="client" type="xsd:integer" />
            <part name="sesskey" type="xsd:string" />
            <part name="labels" type="tns:editLabelsInput" />
          </message>

          <message name="edit_labelsResponse">
            <part name="return" type="tns:editLabelsOutput" />
          </message>
       <!-- /edit_labels -->

      <!-- edit_groups -->
            <message name="edit_groupsRequest">
                <part name="client" type="xsd:integer" />
                <part name="sesskey" type="xsd:string" />
                <part name="groups" type="tns:editGroupsInput" />
            </message>

            <message name="edit_groupsResponse">
                <part name="return" type="tns:editGroupsOutput" />
            </message>
      <!-- /edit_groups -->

       <!-- edit_assignments -->
          <message name="edit_assignmentsRequest">
            <part name="client" type="xsd:integer" />
            <part name="sesskey" type="xsd:string" />
            <part name="assignments" type="tns:editAssignmentsInput" />
          </message>

          <message name="edit_assignmentsResponse">
            <part name="return" type="tns:editAssignmentsOutput" />
          </message>
      <!-- /edit_assignments -->

      <!-- edit_databases -->
          <message name="edit_databasesRequest">
            <part name="client" type="xsd:integer" />
            <part name="sesskey" type="xsd:string" />
            <part name="databases" type="tns:editDatabasesInput" />
          </message>

          <message name="edit_databasesResponse">
            <part name="return" type="tns:editDatabasesOutput" />
          </message>
      <!-- /edit_databases -->

      <!-- edit_categories -->
          <message name="edit_categoriesRequest">
            <part name="client" type="xsd:integer" />
            <part name="sesskey" type="xsd:string" />
            <part name="categories" type="tns:editCategoriesInput" />
          </message>

          <message name="edit_categoriesResponse">
            <part name="return" type="tns:editCategoriesOutput" />
          </message>
       <!-- /edit_categories -->



       <!-- edit_sections -->
          <message name="edit_sectionsRequest">
            <part name="client" type="xsd:integer" />
            <part name="sesskey" type="xsd:string" />
            <part name="sections" type="tns:editSectionsInput" />
          </message>

          <message name="edit_sectionsResponse">
            <part name="return" type="tns:editSectionsOutput" />
          </message>
       <!-- /edit_sections -->

       <!-- edit_forums -->
          <message name="edit_forumsRequest">
            <part name="client" type="xsd:integer" />
            <part name="sesskey" type="xsd:string" />
            <part name="forums" type="tns:editForumsInput" />
          </message>

          <message name="edit_forumsResponse">
            <part name="return" type="tns:editForumsOutput" />
          </message>
       <!-- /edit_forums -->

       <!-- edit_wikis -->
          <message name="edit_wikisRequest">
            <part name="client" type="xsd:integer" />
            <part name="sesskey" type="xsd:string" />
            <part name="wikis" type="tns:editWikisInput" />
          </message>
          <message name="edit_wikisResponse">
            <part name="return" type="tns:editWikisOutput" />
          </message>
       <!-- /edit_wikis -->

       <!-- edit_pagesWiki -->
       <message name="edit_pagesWikiRequest">
            <part name="client" type="xsd:integer" />
            <part name="sesskey" type="xsd:string" />
            <part name="pagesWiki" type="tns:editPagesWikiInput" />
       </message>
       <message name="edit_pagesWikiResponse">
            <part name="return" type="tns:editPagesWikiOutput" />
       </message>
       <!-- /edit_pagesWiki -->

       <!-- affect_course_to_category -->

          <message name="affect_course_to_categoryRequest">
            <part name="client" type="xsd:integer" />
            <part name="sesskey" type="xsd:string" />
            <part name="courseid" type="xsd:integer" />
            <part name="categoryid" type="xsd:integer" />
          </message>

       <!-- /affect_course_to_category -->

       <!-- affect_label_to_section -->

          <message name="affect_label_to_sectionRequest">
            <part name="client" type="xsd:integer" />
            <part name="sesskey" type="xsd:string" />
            <part name="labelid" type="xsd:integer" />
            <part name="sectionid" type="xsd:integer" />
          </message>

       <!-- /affect_label_to_section -->

        <!-- affect_forum_to_section -->
          <message name="affect_forum_to_sectionRequest">
            <part name="client" type="xsd:integer" />
            <part name="sesskey" type="xsd:string" />
            <part name="forumid" type="xsd:integer" />
            <part name="sectionid" type="xsd:integer" />
            <part name="groupmode" type="xsd:integer" />
          </message>
       <!-- /affect_forum_to_section -->

       <!-- affect_section_to_course -->
          <message name="affect_section_to_courseRequest">
            <part name="client" type="xsd:integer" />
            <part name="sesskey" type="xsd:string" />
            <part name="sectionid" type="xsd:integer" />
            <part name="courseid" type="xsd:integer" />
          </message>
       <!-- /affect_section_to_course -->

       <!-- affect_user_to_group -->
           <message name="affect_user_to_groupRequest">
            <part name="client" type="xsd:integer" />
            <part name="sesskey" type="xsd:string" />
            <part name="userid" type="xsd:integer" />
            <part name="groupid" type="xsd:integer" />
          </message>
          <message name="affect_user_to_groupResponse">
            <part name="return" type="tns:affectRecord" />
          </message>
      <!-- /affect_user_to_group -->

      <!-- affect_group_to_course -->
          <message name="affect_group_to_courseRequest">
            <part name="client" type="xsd:integer" />
            <part name="sesskey" type="xsd:string" />
            <part name="groupid" type="xsd:integer" />
            <part name="coursid" type="xsd:integer" />
          </message>
          <message name="affect_group_to_courseResponse">
            <part name="return" type="tns:affectRecord" />
          </message>
      <!-- /affect_group_to_course -->

      <!-- affect_wiki_to_section -->
          <message name="affect_wiki_to_sectionRequest">
            <part name="client" type="xsd:integer" />
            <part name="sesskey" type="xsd:string" />
            <part name="wikiid" type="xsd:integer" />
            <part name="sectionid" type="xsd:integer" />
            <part name="groupmode" type="xsd:integer" />
            <part name="visible" type="xsd:integer" />
          </message>
          <message name="affect_wiki_to_sectionResponse">
            <part name="return" type="tns:affectRecord" />
          </message>
      <!-- /affect_wiki_to_section -->

      <!-- affect_database_to_section -->
          <message name="affect_database_to_sectionRequest">
            <part name="client" type="xsd:integer" />
            <part name="sesskey" type="xsd:string" />
            <part name="databaseid" type="xsd:integer" />
            <part name="sectionid" type="xsd:integer" />
          </message>
          <message name="affect_database_to_sectionResponse">
            <part name="return" type="tns:affectRecord" />
          </message>
      <!-- /affect_database_to_section -->

      <!-- affect_assignment_to_section -->
          <message name="affect_assignment_to_sectionRequest">
            <part name="client" type="xsd:integer" />
            <part name="sesskey" type="xsd:string" />
            <part name="assignmentid" type="xsd:integer" />
            <part name="sectionid" type="xsd:integer" />
            <part name="groupmode" type="xsd:integer" />
          </message>
          <message name="affect_assignment_to_sectionResponse">
            <part name="return" type="tns:affectRecord" />
          </message>
      <!-- /affect_assignment_to_section -->

      <!-- affect_user_to_course -->
          <message name="affect_user_to_courseRequest">
            <part name="client" type="xsd:integer" />
            <part name="sesskey" type="xsd:string" />
            <part name="userid" type="xsd:integer" />
            <part name="courseid" type="xsd:integer" />
            <part name="rolename" type="xsd:string"/>
          </message>
      <!-- /affect_user_to_course -->

      <!-- affect_pageWiki_to_wiki -->
      <message name="affect_pageWiki_to_wikiRequest">
        <part name="client" type="xsd:integer" />
        <part name="sesskey" type="xsd:string" />
        <part name="pageid" type="xsd:integer" />
        <part name="wikiid" type="xsd:integer" />
      </message>
      <!-- /affect_pageWiki_to_wiki -->

      <!-- remove_userRole_from_course -->
      <message name="remove_userRole_from_courseRequest">
        <part name="client" type="xsd:integer" />
        <part name="sesskey" type="xsd:string" />
        <part name="userid" type="xsd:integer" />
        <part name="courseid" type="xsd:integer" />
        <part name="rolename" type="xsd:string"/>
      </message>
      <!-- /remove_user_from_course -->

       <!-- get_all_forums -->
          <message name="get_all_forumsResponse">
            <part name="return" type="tns:getAllForumsReturn" />
          </message>
       <!-- /get_all_forums -->

       <!-- get_all_labels -->
          <message name="get_all_labelsResponse">
            <part name="return" type="tns:getAllLabelsReturn" />
          </message>
       <!-- /get_all_labels -->

       <!-- get_all_wikis -->
          <message name="get_all_wikisResponse">
            <part name="return" type="tns:getAllWikisReturn" />
          </message>
       <!-- /get_all_wikis -->

       <!-- get_all_pagesWiki -->
          <message name="get_all_pagesWikiResponse">
            <part name="return" type="tns:getAllPagesWikiReturn" />
          </message>
       <!-- /get_all_pagesWiki -->

       <!-- get_all_assignments -->
          <message name="get_all_assignmentsResponse">
            <part name="return" type="tns:getAllAssignmentsReturn" />
          </message>
       <!-- /get_all_assignments -->

       <!-- get_all_databases -->
          <message name="get_all_databasesResponse">
            <part name="return" type="tns:getAllDatabasesReturn" />
          </message>
       <!-- /get_all_databases -->

  <!-- /MESSAGES FROM LILLE -->

  <portType name="MoodleWSPortType">
    <operation name="login">
      <documentation>MoodleWS Client Login</documentation>
      <input message="tns:loginRequest" />
      <output message="tns:loginResponse" />
    </operation>

    <operation name="logout">
      <documentation>MoodleWS: Client Logout</documentation>
      <input message="tns:logoutRequest" />
      <output message="tns:logoutResponse" />
    </operation>

    <operation name="get_course">
      <documentation>MoodleWS: Get Course Information</documentation>
      <input message="tns:get_courseRequest" />
      <output message="tns:get_coursesResponse" />
    </operation>

    <operation name="get_course_byid">
      <documentation>MoodleWS: Get Course Information</documentation>
      <input message="tns:get_course_byRequest" />
      <output message="tns:get_coursesResponse" />
    </operation>

    <operation name="get_course_byidnumber">
      <documentation>MoodleWS: Get Course Information</documentation>
      <input message="tns:get_course_byRequest" />
      <output message="tns:get_coursesResponse" />
    </operation>

    <operation name="get_groups_bycourse">
      <documentation>MoodleWS: Get Course groups</documentation>
      <input message="tns:get_groups_bycourseRequest" />
      <output message="tns:get_groupsResponse" />
    </operation>

    <operation name="get_group_byid">
      <documentation>MoodleWS: Get Course Information</documentation>
      <input message="tns:get_group_byRequest" />
      <output message="tns:get_groupsResponse" />
    </operation>

    <operation name="get_groups_byname">
      <documentation>MoodleWS: Get Course Information</documentation>
      <input message="tns:get_group_byRequest" />
      <output message="tns:get_groupsResponse" />
    </operation>

   <operation name="get_user">
      <documentation>MoodleWS: Get one User Information</documentation>
      <input message="tns:get_userRequest" />
      <output message="tns:get_usersResponse" />
    </operation>


    <operation name="edit_users">
      <documentation>MoodleWS: Edit Users Information</documentation>
      <input message="tns:edit_usersRequest" />
      <output message="tns:edit_usersResponse" />
    </operation>
    <operation name="get_users">
      <documentation>MoodleWS: Get Users Information</documentation>
      <input message="tns:get_usersRequest" />
      <output message="tns:get_usersResponse" />
    </operation>

    <operation name="get_teachers">
      <documentation>MoodleWS: Get course teachers</documentation>
      <input message="tns:valueAndIdRequest" />
      <output message="tns:get_usersResponse" />
    </operation>

    <operation name="get_students">
      <documentation>MoodleWS: Get course students</documentation>
      <input message="tns:valueAndIdRequest" />
      <output message="tns:get_usersResponse" />
    </operation>

    <operation name="edit_courses">
      <documentation>MoodleWS: Edit Courses Information</documentation>
      <input message="tns:edit_coursesRequest" />
      <output message="tns:edit_coursesResponse" />
    </operation>

    <operation name="get_courses">
      <documentation>MoodleWS: Get Courses Information</documentation>
      <input message="tns:get_coursesRequest" />
      <output message="tns:get_coursesResponse" />
    </operation>

   <operation name="get_resources">
      <documentation>MoodleWS: Get resources in courses</documentation>
      <input message="tns:get_coursesRequest" />
      <output message="tns:get_resourcesResponse" />
    </operation>

   <operation name="get_instances_bytype">
      <documentation>MoodleWS: Get resources in courses</documentation>
      <input message="tns:get_instances_bytypeRequest" />
      <output message="tns:get_resourcesResponse" />
    </operation>


    <operation name="get_grades">
      <documentation>MoodleWS: Get User Grades in some courses</documentation>
      <input message="tns:get_gradesRequest" />
      <output message="tns:get_gradesResponse" />
    </operation>
    <operation name="get_course_grades">
      <documentation>MoodleWS: Get all Users  Grades in one course</documentation>
      <input message="tns:valueAndIdRequest" />
      <output message="tns:get_gradesResponse" />
    </operation>

     <operation name="get_user_grades">
      <documentation>MoodleWS: Get User Grades in all courses</documentation>
      <input message="tns:valueAndIdRequest" />
      <output message="tns:get_gradesResponse" />
    </operation>

    <operation name="enrol_students">
      <documentation>
        MoodleWS: Enrol students in a course
      </documentation>
      <input message="tns:enrol_studentsRequest" />
      <output message="tns:enrol_studentsResponse" />
    </operation>
 <operation name="unenrol_students">
      <documentation>
        MoodleWS: UnEnrol students in a course
      </documentation>
      <input message="tns:enrol_studentsRequest" />
      <output message="tns:enrol_studentsResponse" />
    </operation>

    <operation name="get_roles">
      <documentation>MoodleWS: Get All roles defined in Moodle</documentation>
      <input message="tns:noinputRequest" />
      <output message="tns:get_rolesResponse" />
    </operation>

    <operation name="get_role_byid">
      <documentation>MoodleWS: Get one role defined in Moodle</documentation>
      <input message="tns:oneValueRequest" />
      <output message="tns:get_rolesResponse" />
    </operation>

   <operation name="get_role_byname">
      <documentation>MoodleWS: Get one role defined in Moodle</documentation>
      <input message="tns:oneValueRequest" />
      <output message="tns:get_rolesResponse" />
    </operation>


    <operation name="get_events">
      <documentation>MoodleWS: Get Moodle s events </documentation>
      <input message="tns:get_eventsRequest" />
      <output message="tns:get_eventsResponse" />
    </operation>

   <operation name="get_last_changes">
      <documentation>MoodleWS: Get last changes to a Moodle s course </documentation>
      <input message="tns:get_last_changesRequest" />
      <output message="tns:get_last_changesResponse" />
    </operation>

   <operation name="get_categories">
      <documentation>MoodleWS: Get  Moodle  course categories</documentation>
      <input message="tns:noinputRequest" />
      <output message="tns:get_categoriesResponse" />
    </operation>

    <operation name="get_category_byid">
      <documentation>MoodleWS: Get one category defined in Moodle</documentation>
      <input message="tns:oneValueRequest" />
      <output message="tns:get_categoriesResponse" />
    </operation>

   <operation name="get_category_byname">
      <documentation>MoodleWS: Get one category defined in Moodle</documentation>
      <input message="tns:oneValueRequest" />
      <output message="tns:get_categoriesResponse" />
    </operation>


   <operation name="get_my_courses">
      <documentation>MoodleWS: Get Courses user identified by id is member of </documentation>
      <input message="tns:get_my_coursesRequest" />
      <output message="tns:get_coursesResponse" />
    </operation>

    <operation name="get_my_courses_byidnumber">
      <documentation>MoodleWS: Get Courses current user identified by idnumber is  member of </documentation>
      <input message="tns:get_my_courses_byRequest" />
      <output message="tns:get_coursesResponse" />
    </operation>

   <operation name="get_my_courses_byusername">
      <documentation>MoodleWS: Get Courses current user identified by username is  member of </documentation>
      <input message="tns:get_my_courses_byRequest" />
      <output message="tns:get_coursesResponse" />
    </operation>


   <operation name="get_courses_bycategory">
      <documentation>MoodleWS: Get Courses belonging to category </documentation>
      <input message="tns:get_courses_bycategoryRequest" />
      <output message="tns:get_coursesResponse" />
    </operation>

<operation name="get_sections">
      <documentation>MoodleWS: Get Course sections </documentation>
      <input message="tns:get_coursesRequest" />
      <output message="tns:get_sectionsResponse" />
    </operation>

    <operation name="get_user_byusername">
      <documentation>MoodleWS: Get user info from Moodle user login</documentation>
      <input message="tns:get_user_byRequest" />
      <output message="tns:get_usersResponse" />
    </operation>
    <operation name="get_user_byidnumber">
      <documentation>MoodleWS: Get user info from Moodle user id number</documentation>
      <input message="tns:get_user_byRequest" />
      <output message="tns:get_usersResponse" />
    </operation>
    <operation name="get_user_byid">
      <documentation>MoodleWS: Get user info from Moodle user id</documentation>
      <input message="tns:get_user_byRequest" />
      <output message="tns:get_usersResponse" />
    </operation>

   <operation name="get_users_bycourse">
      <documentation>MoodleWS: Get users having a role in a course</documentation>
      <input message="tns:get_users_bycourseRequest" />
      <output message="tns:get_usersResponse" />
    </operation>

    <operation name="count_users_bycourse">
      <documentation>MoodleWS: count users having a role in a course</documentation>
      <input message="tns:get_users_bycourseRequest" />
      <output message="tns:integerResponse" />
    </operation>


    <operation name="get_group_members">
      <documentation>MoodleWS: Get users members of a group in course</documentation>
      <input message="tns:get_group_membersRequest" />
      <output message="tns:get_usersResponse" />
    </operation>




   <operation name="get_my_group">
      <documentation>MoodleWS: Get user group in course</documentation>
      <input message="tns:get_my_groupRequest" />
      <output message="tns:get_groupsResponse" />
    </operation>

   <operation name="get_my_groups">
      <documentation>MoodleWS: Get user groups in all Moodle site</documentation>
      <input message="tns:get_my_groupsRequest" />
      <output message="tns:get_groupsResponse" />
    </operation>

    <operation name="get_my_id">
      <documentation>MoodleWS: get current user Moodle internal id (helper)</documentation>
      <input message="tns:noinputRequest" />
      <output message="tns:integerResponse" />
    </operation>

         <operation name="get_version">
      <documentation>MoodleWS: get current version</documentation>
      <input message="tns:noinputRequest" />
      <output message="tns:stringResponse" />
    </operation>

  <operation name="has_role_incourse">
      <documentation>MoodleWS: check if user has a given role in a given course </documentation>
      <input message="tns:has_role_incourseRequest" />
      <output message="tns:booleanResponse" />
    </operation>

  <operation name="get_primaryrole_incourse">
      <documentation>MoodleWS: returns  user s primary role in a given course </documentation>
      <input message="tns:get_primaryrole_incourseRequest" />
      <output message="tns:integerResponse" />
    </operation>


    <operation name="get_activities">
      <documentation>MoodleWS: Get user most recent activities in a Moodle course</documentation>
      <input message="tns:get_activitiesRequest" />
      <output message="tns:get_activitiesResponse" />
    </operation>

    <operation name="count_activities">
      <documentation>MoodleWS: count user most recent activities in a Moodle course</documentation>
      <input message="tns:twoValuesAndIdsRequest" />
      <output message="tns:integerResponse" />
    </operation>

<!-- OPERATION FROM LILLE -->

    <operation name="edit_labels">
          <documentation>MoodleWS: Edit Label Information</documentation>
          <input message="tns:edit_labelsRequest" />
          <output message="tns:edit_labelsResponse" />
        </operation>

        <operation name="edit_groups">
          <documentation>MoodleWS: Edit Groups Information</documentation>
          <input message="tns:edit_groupsRequest" />
          <output message="tns:edit_groupsResponse" />
        </operation>

        <operation name="edit_assignments">
          <documentation>MoodleWS: Edit Assignment Information</documentation>
          <input message="tns:edit_assignmentsRequest" />
          <output message="tns:edit_assignmentsResponse" />
        </operation>

        <operation name="edit_databases">
          <documentation>MoodleWS: Edit databases Information</documentation>
          <input message="tns:edit_databasesRequest" />
          <output message="tns:edit_databasesResponse" />
        </operation>

        <operation name="edit_categories">
          <documentation>MoodleWS: Edit Categories Information</documentation>
          <input message="tns:edit_categoriesRequest" />
          <output message="tns:edit_categoriesResponse" />
        </operation>


        <operation name="edit_sections">
          <documentation>MoodleWS: Edit section Information</documentation>
          <input message="tns:edit_sectionsRequest" />
          <output message="tns:edit_sectionsResponse" />
        </operation>

        <operation name="edit_forums">
          <documentation>MoodleWS: Edit Forum Information</documentation>
          <input message="tns:edit_forumsRequest" />
          <output message="tns:edit_forumsResponse" />
        </operation>

        <operation name="edit_wikis">
          <documentation>MoodleWS: Edit Wikis Information</documentation>
          <input message="tns:edit_wikisRequest" />
          <output message="tns:edit_wikisResponse" />
        </operation>

        <operation name="edit_pagesWiki">
          <documentation>MoodleWS: Edit Page of Wiki Information</documentation>
          <input message="tns:edit_pagesWikiRequest" />
          <output message="tns:edit_pagesWikiResponse" />
        </operation>

        <operation name="affect_course_to_category">
          <documentation>MoodleWS: Affect Course To Category</documentation>
          <input message="tns:affect_course_to_categoryRequest" />
          <output message="tns:affectResponse" />
        </operation>

         <operation name="affect_label_to_section">
          <documentation>MoodleWS: Affect Label to Section</documentation>
          <input message="tns:affect_label_to_sectionRequest" />
          <output message="tns:affectResponse" />
        </operation>

        <operation name="affect_forum_to_section">
          <documentation>MoodleWS: Affect Forum to Section</documentation>
          <input message="tns:affect_forum_to_sectionRequest" />
          <output message="tns:affectResponse" />
        </operation>

        <operation name="affect_section_to_course">
          <documentation>MoodleWS: Affect Section To Course</documentation>
          <input message="tns:affect_section_to_courseRequest" />
          <output message="tns:affectResponse" />
        </operation>

        <operation name="affect_user_to_group">
          <documentation>MoodleWS: Affect a user to group</documentation>
          <input message="tns:affect_user_to_groupRequest" />
          <output message="tns:affect_user_to_groupResponse" />
        </operation>

        <operation name="affect_group_to_course">
          <documentation>MoodleWS: Affect a group to course</documentation>
          <input message="tns:affect_group_to_courseRequest" />
          <output message="tns:affect_group_to_courseResponse" />
        </operation>

        <operation name="affect_wiki_to_section">
          <documentation>MoodleWS: Affect a wiki to section</documentation>
          <input message="tns:affect_wiki_to_sectionRequest" />
          <output message="tns:affect_wiki_to_sectionResponse" />
        </operation>

         <operation name="affect_database_to_section">
          <documentation>MoodleWS: Affect a database to section</documentation>
          <input message="tns:affect_database_to_sectionRequest" />
          <output message="tns:affect_database_to_sectionResponse" />
        </operation>

        <operation name="affect_assignment_to_section">
          <documentation>MoodleWS: Affect a section to assignment</documentation>
          <input message="tns:affect_assignment_to_sectionRequest" />
          <output message="tns:affect_assignment_to_sectionResponse" />
        </operation>

        <operation name="affect_user_to_course">
          <documentation>MoodleWS: Affect user to the course</documentation>
          <input message="tns:affect_user_to_courseRequest" />
          <output message="tns:affectResponse" />
        </operation>

        <operation name="affect_pageWiki_to_wiki">
          <documentation>MoodleWS: Affect a page of wiki to a wiki</documentation>
          <input message="tns:affect_pageWiki_to_wikiRequest" />
          <output message="tns:affectResponse" />
        </operation>

        <operation name="remove_userRole_from_course">
          <documentation>MoodleWS: Remove the role specified of the user in the course</documentation>
          <input message="tns:remove_userRole_from_courseRequest" />
          <output message="tns:affectResponse" />
        </operation>

        <operation name="get_all_groups">
          <documentation>MoodleWS: Get All Groups</documentation>
          <input message="tns:get_genericRequest" />
          <output message="tns:get_groupsResponse" />
        </operation>

        <operation name="get_all_forums">
          <documentation>MoodleWS: Get All Forums</documentation>
          <input message="tns:get_genericRequest" />
          <output message="tns:get_all_forumsResponse" />
        </operation>

        <operation name="get_all_labels">
          <documentation>MoodleWS: Get All Labels</documentation>
          <input message="tns:get_genericRequest" />
          <output message="tns:get_all_labelsResponse" />
        </operation>

        <operation name="get_all_wikis">
          <documentation>MoodleWS: Get All wikis</documentation>
          <input message="tns:get_genericRequest" />
          <output message="tns:get_all_wikisResponse" />
        </operation>

        <operation name="get_all_pagesWiki">
          <documentation>MoodleWS: Get All Pages Wikis</documentation>
          <input message="tns:get_genericRequest" />
          <output message="tns:get_all_pagesWikiResponse" />
        </operation>

        <operation name="get_all_assignments">
          <documentation>MoodleWS: Get All Assignments</documentation>
          <input message="tns:get_genericRequest" />
          <output message="tns:get_all_assignmentsResponse" />
        </operation>

        <operation name="get_all_databases">
          <documentation>MoodleWS: Get All Databases</documentation>
          <input message="tns:get_genericRequest" />
          <output message="tns:get_all_databasesResponse" />
        </operation>

    <!-- /OPERATION FROM LILLE -->


  </portType>

  <binding name="MoodleWSBinding" type="tns:MoodleWSPortType">
    <soap:binding style="rpc"
      transport="http://schemas.xmlsoap.org/soap/http" />
    <operation name="login">
      <soap:operation
        soapAction="' . $CFG->wwwroot . '/wspp/wsdl#login"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>
    <operation name="logout">
      <soap:operation
        soapAction="' . $CFG->wwwroot . '/wspp/wsdl#logout"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>
    <operation name="edit_users">
      <soap:operation
        soapAction="' . $CFG->wwwroot . '/wspp/wsdl#edit_users"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>
    <operation name="get_users">
      <soap:operation
        soapAction="' . $CFG->wwwroot . '/wspp/wsdl#get_users"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>
    <operation name="edit_courses">
      <soap:operation
        soapAction="' . $CFG->wwwroot . '/wspp/wsdl#edit_courses"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>
    <operation name="get_courses">
      <soap:operation
        soapAction="' . $CFG->wwwroot . '/wspp/wsdl#get_courses"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>

   <operation name="get_resources">
      <soap:operation
        soapAction="' . $CFG->wwwroot . '/wspp/wsdl#get_resources"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>
<operation name="get_version">
      <soap:operation
        soapAction="' . $CFG->wwwroot . '/wspp/wsdl#get_version"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>
 <operation name="get_sections">
      <soap:operation
        soapAction="' . $CFG->wwwroot . '/wspp/wsdl#get_sections"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>

  <operation name="get_instances_bytype">
      <soap:operation
        soapAction="' . $CFG->wwwroot . '/wspp/wsdl#get_instances_bytype"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>


    <operation name="get_grades">
      <soap:operation
        soapAction="' . $CFG->wwwroot . '/wspp/wsdl#get_grades"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>

     <operation name="get_user_grades">
      <soap:operation
        soapAction="' . $CFG->wwwroot . '/wspp/wsdl#get_user_grades"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>
<operation name="get_course_grades">
      <soap:operation
        soapAction="' . $CFG->wwwroot . '/wspp/wsdl#get_course_grades"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>
    <operation name="enrol_students">
      <soap:operation
        soapAction="' . $CFG->wwwroot . '/wspp/wsdl#enrol_students"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>

 <operation name="unenrol_students">
      <soap:operation
        soapAction="' . $CFG->wwwroot . '/wspp/wsdl#unenrol_students"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="' . $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>


    <operation name="get_last_changes">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_last_changes"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>

    <operation name="get_events">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_events"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>

    <operation name="get_course">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_course"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>

 <operation name="get_course_byid">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_course_byid"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>

 <operation name="get_course_byidnumber">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_course_byidnumber"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>


    <operation name="get_user">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_user"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>


    <operation name="get_roles">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_roles"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>

   <operation name="get_role_byid">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_role_byid"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
     </operation>

    <operation name="get_role_byname">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_role_byname"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
     </operation>





    <operation name="get_categories">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_categories"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>

   <operation name="get_category_byid">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_category_byid"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
     </operation>

     <operation name="get_category_byname">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_category_byname"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
     </operation>


    <operation name="get_my_courses">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_my_courses"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>

     <operation name="get_my_courses_byusername">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_my_courses_byusername"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>

     <operation name="get_my_courses_byidnumber">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_my_courses_byidnumber"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>



    <operation name="get_user_byusername">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_user_byusername"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>
    <operation name="get_user_byidnumber">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_user_byidnumber"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
     </operation>
     <operation name="get_user_byid">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_user_byid"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
    </operation>
   <operation name="get_users_bycourse">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_users_bycourse"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
     </operation>

    <operation name="count_users_bycourse">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#count_users_bycourse"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
     </operation>

     <operation name="get_courses_bycategory">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_courses_bycategory"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
     </operation>

   <operation name="get_groups_bycourse">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_groups_bycourse"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
     </operation>

<operation name="get_group_byid">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_group_byid"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
     </operation>

  <operation name="get_groups_byname">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_groups_byname"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
     </operation>


 <operation name="get_group_members">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_group_members"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
     </operation>

<operation name="get_my_id">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_my_id"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
     </operation>


<operation name="get_my_group">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_my_group"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
     </operation>

<operation name="get_my_groups">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_my_groups"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
     </operation>
  <operation name="get_teachers">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_teachers"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
     </operation>

   <operation name="get_students">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_students"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
   </operation>

  <operation name="has_role_incourse">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#has_role_incourse"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
     </operation>

     <operation name="get_primaryrole_incourse">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_primaryrole_incourse"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
     </operation>


    <operation name="get_activities">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_activities"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
     </operation>

<operation name="count_activities">
      <soap:operation
        soapAction="'. $CFG->wwwroot . '/wspp/wsdl#count_activities"
        style="rpc" />
      <input>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </input>
      <output>
        <soap:body use="encoded"
          namespace="'. $CFG->wwwroot . '/wspp/wsdl"
          encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
      </output>
     </operation>

  <!-- BINDING FROM LILLE -->

    <operation name="edit_labels">
          <soap:operation
            soapAction="'. $CFG->wwwroot . '/wspp/wsdl#edit_labels"
            style="rpc" />
          <input>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </input>
          <output>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </output>
         </operation>

        <operation name="edit_groups">
          <soap:operation
            soapAction="' . $CFG->wwwroot . '/wspp/wsdl#edit_groups"
            style="rpc" />
          <input>
            <soap:body use="encoded"
              namespace="' . $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </input>
          <output>
            <soap:body use="encoded"
              namespace="' . $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </output>
        </operation>

        <operation name="edit_assignments">
          <soap:operation
            soapAction="' . $CFG->wwwroot . '/wspp/wsdl#edit_assignments"
            style="rpc" />
          <input>
            <soap:body use="encoded"
              namespace="' . $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </input>
          <output>
            <soap:body use="encoded"
              namespace="' . $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </output>
        </operation>

        <operation name="edit_databases">
          <soap:operation
            soapAction="'. $CFG->wwwroot . '/wspp/wsdl#edit_databases"
            style="rpc" />
          <input>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </input>
          <output>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </output>
         </operation>

        <operation name="edit_categories">
          <soap:operation
            soapAction="'. $CFG->wwwroot . '/wspp/wsdl#edit_categories"
            style="rpc" />
          <input>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </input>
          <output>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </output>
         </operation>



         <operation name="edit_sections">
          <soap:operation
            soapAction="'. $CFG->wwwroot . '/wspp/wsdl#edit_sections"
            style="rpc" />
          <input>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </input>
          <output>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </output>
         </operation>

         <operation name="edit_forums">
          <soap:operation
            soapAction="'. $CFG->wwwroot . '/wspp/wsdl#edit_forums"
            style="rpc" />
          <input>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </input>
          <output>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </output>
         </operation>

         <operation name="edit_wikis">
              <soap:operation
                soapAction="' . $CFG->wwwroot . '/wspp/wsdl#edit_wikis"
                style="rpc" />
              <input>
                <soap:body use="encoded"
                  namespace="' . $CFG->wwwroot . '/wspp/wsdl"
                  encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
              </input>
              <output>
                <soap:body use="encoded"
                  namespace="' . $CFG->wwwroot . '/wspp/wsdl"
                  encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
              </output>
         </operation>

         <operation name="edit_pagesWiki">
              <soap:operation
                soapAction="' . $CFG->wwwroot . '/wspp/wsdl#edit_pagesWiki"
                style="rpc" />
              <input>
                <soap:body use="encoded"
                  namespace="' . $CFG->wwwroot . '/wspp/wsdl"
                  encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
              </input>
              <output>
                <soap:body use="encoded"
                  namespace="' . $CFG->wwwroot . '/wspp/wsdl"
                  encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
              </output>
          </operation>

         <operation name="affect_course_to_category">
          <soap:operation
            soapAction="'. $CFG->wwwroot . '/wspp/wsdl#affect_course_to_category"
            style="rpc" />
          <input>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </input>
          <output>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </output>
         </operation>

         <operation name="affect_label_to_section">
          <soap:operation
            soapAction="'. $CFG->wwwroot . '/wspp/wsdl#affect_label_to_section"
            style="rpc" />
          <input>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </input>
          <output>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </output>
         </operation>

         <operation name="affect_forum_to_section">
          <soap:operation
            soapAction="'. $CFG->wwwroot . '/wspp/wsdl#affect_forum_to_section"
            style="rpc" />
          <input>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </input>
          <output>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </output>
         </operation>

          <operation name="affect_section_to_course">
          <soap:operation
            soapAction="'. $CFG->wwwroot . '/wspp/wsdl#affect_section_to_course"
            style="rpc" />
          <input>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </input>
          <output>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </output>
         </operation>

        <operation name="affect_user_to_group">
             <soap:operation
                soapAction="'. $CFG->wwwroot . '/wspp/wsdl#affect_user_to_group"
                style="rpc" />
              <input>
                <soap:body use="encoded"
                  namespace="'. $CFG->wwwroot . '/wspp/wsdl"
                  encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
              </input>
              <output>
                <soap:body use="encoded"
                  namespace="'. $CFG->wwwroot . '/wspp/wsdl"
                  encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
              </output>
        </operation>

        <operation name="affect_group_to_course">
             <soap:operation
                soapAction="'. $CFG->wwwroot . '/wspp/wsdl#affect_group_to_course"
                style="rpc" />
              <input>
                <soap:body use="encoded"
                  namespace="'. $CFG->wwwroot . '/wspp/wsdl"
                  encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
              </input>
              <output>
                <soap:body use="encoded"
                  namespace="'. $CFG->wwwroot . '/wspp/wsdl"
                  encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
              </output>
        </operation>

        <operation name="affect_wiki_to_section">
             <soap:operation
                soapAction="'. $CFG->wwwroot . '/wspp/wsdl#affect_wiki_to_section"
                style="rpc" />
              <input>
                <soap:body use="encoded"
                  namespace="'. $CFG->wwwroot . '/wspp/wsdl"
                  encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
              </input>
              <output>
                <soap:body use="encoded"
                  namespace="'. $CFG->wwwroot . '/wspp/wsdl"
                  encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
              </output>
         </operation>

         <operation name="affect_database_to_section">
             <soap:operation
                soapAction="'. $CFG->wwwroot . '/wspp/wsdl#affect_database_to_section"
                style="rpc" />
              <input>
                <soap:body use="encoded"
                  namespace="'. $CFG->wwwroot . '/wspp/wsdl"
                  encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
              </input>
              <output>
                <soap:body use="encoded"
                  namespace="'. $CFG->wwwroot . '/wspp/wsdl"
                  encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
              </output>
         </operation>

         <operation name="affect_assignment_to_section">
             <soap:operation
                soapAction="'. $CFG->wwwroot . '/wspp/wsdl#affect_assignment_to_section"
                style="rpc" />
              <input>
                <soap:body use="encoded"
                  namespace="'. $CFG->wwwroot . '/wspp/wsdl"
                  encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
              </input>
              <output>
                <soap:body use="encoded"
                  namespace="'. $CFG->wwwroot . '/wspp/wsdl"
                  encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
              </output>
         </operation>

        <operation name="affect_user_to_course">
          <soap:operation
            soapAction="' . $CFG->wwwroot . '/wspp/wsdl#affect_user_to_course"
            style="rpc" />
          <input>
            <soap:body use="encoded"
              namespace="' . $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </input>
          <output>
            <soap:body use="encoded"
              namespace="' . $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </output>
        </operation>

        <operation name="affect_pageWiki_to_wiki">
          <soap:operation
            soapAction="' . $CFG->wwwroot . '/wspp/wsdl#affect_pageWiki_to_wiki"
            style="rpc" />
          <input>
            <soap:body use="encoded"
              namespace="' . $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </input>
          <output>
            <soap:body use="encoded"
              namespace="' . $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </output>
         </operation>

        <operation name="remove_userRole_from_course">
          <soap:operation
            soapAction="' . $CFG->wwwroot . '/wspp/wsdl#remove_userRole_from_course"
            style="rpc" />
          <input>
            <soap:body use="encoded"
              namespace="' . $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </input>
          <output>
            <soap:body use="encoded"
              namespace="' . $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </output>
        </operation>

         <operation name="get_all_groups">
          <soap:operation
            soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_all_groups"
            style="rpc" />
          <input>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </input>
          <output>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </output>
         </operation>

         <operation name="get_all_forums">
          <soap:operation
            soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_all_forums"
            style="rpc" />
          <input>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </input>
          <output>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </output>
         </operation>

         <operation name="get_all_labels">
          <soap:operation
            soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_all_labels"
            style="rpc" />
          <input>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </input>
          <output>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </output>
         </operation>

         <operation name="get_all_wikis">
          <soap:operation
            soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_all_wikis"
            style="rpc" />
          <input>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </input>
          <output>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </output>
         </operation>

         <operation name="get_all_pagesWiki">
          <soap:operation
            soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_all_pagesWiki"
            style="rpc" />
          <input>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </input>
          <output>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </output>
         </operation>

         <operation name="get_all_assignments">
          <soap:operation
            soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_all_assignments"
            style="rpc" />
          <input>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </input>
          <output>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </output>
         </operation>

         <operation name="get_all_databases">
          <soap:operation
            soapAction="'. $CFG->wwwroot . '/wspp/wsdl#get_all_databases"
            style="rpc" />
          <input>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </input>
          <output>
            <soap:body use="encoded"
              namespace="'. $CFG->wwwroot . '/wspp/wsdl"
              encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
          </output>
         </operation>

     <!-- /BINDING FROM LILLE -->

  </binding>
  <service name="MoodleWS">
    <port name="MoodleWSPort" binding="tns:MoodleWSBinding">
      <soap:address
        location="' . $CFG->wwwroot . '/wspp/service_pp.php" />
    </port>
  </service>
</definitions>';

?>
