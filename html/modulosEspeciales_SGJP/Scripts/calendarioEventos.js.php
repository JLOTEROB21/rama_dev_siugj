<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

Ext.onReady(inicializar);

function inicializar()
{
	$('#calendar').fullCalendar(
    								{

                                     	header: 
                                        		{
                            		                left: 'prev,next today',
                                                    center: 'title',
                                    	            right: 'month,agendaWeek,agendaDay'
                                    	        },

                                                defaultDate: '2016-01-12',
                                                businessHours: true, // display business hours
                                                editable: true,
                                                events: [
                                                            {
                                                                title: 'Business Lunch',
                                                                start: '2016-01-03T13:00:00',
                                                                end: '2016-01-03T14:00:00',
                                                                constraint: 'businessHours'
                                                        
                                                            },
                                                            {
                                                                title: 'Meeting',
                                                                start: '2016-01-13T11:00:00',
                                                                constraint: 'availableForMeeting', // defined below
                                                                color: '#257e4a'
                                                            },
                                                            {
                                                                title: 'Conference',
                                                                start: '2016-01-18',
                                                                end: '2016-01-20'
                                                            },
                                                            {
                                                                title: 'Party',
                                                                start: '2016-01-29T20:00:00'
                                                            },
                                                            // areas where "Meeting" must be dropped
                                                            {
                                                                id: 'availableForMeeting',
                                                                start: '2016-01-11T10:00:00',
                                                                end: '2016-01-11T16:00:00',
                                                                rendering: 'background'
                                                            },
                                                            {
                                                                id: 'availableForMeeting',
                                                                start: '2016-01-13T10:00:00',
                                                                end: '2016-01-13T16:00:00',
                                                                rendering: 'background'
                                                            },
                                                            // red areas where no events can be dropped
                                                            {
                                                                start: '2016-01-24',
                                                                end: '2016-01-28',
                                                                overlap: false,
                                                                rendering: 'background',
                                                                color: '#ff9f89'
                                                            },
                                                            {
                                                                start: '2016-01-06',
                                                                end: '2016-01-08',					
                                                                overlap: false,
                                                                rendering: 'background',
                                                                color: '#ff9f89'
                                                            }
                                                        ]
                                                
             						 }
                               );

}