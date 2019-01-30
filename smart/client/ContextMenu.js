isc.defineClass("myContextMenu", "myMenu").addProperties({
	parent: this,
	callingListGrid: null,
	data: [
		{title: "Add",
			click: function(target, item, menu, colNum){
				if(menu.callingListGrid.canEdit){
					menu.callingListGrid.startEditingNew();
				}
			}
		},
		{title: "Edit",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				var row = menu.callingListGrid.getRowNum(record);
				menu.callingListGrid.rowDoubleClick(record, row);
			}
		},
		{title: "Refresh",
			click: function(target, item, menu, colNum){
				menu.callingListGrid.invalidateCache();
			}
		},
		{title: "Copy Row",
			click: function(target, item, menu, colNum){
				var record;
				var text = "";
				if(menu.callingListGrid.anySelected()){
					record = menu.callingListGrid.getSelectedRecord();
					isc.say(copyValues(record));
					// ToDo: Fix this so it only shows proper values.
					// for(var key in record) {
					// 	let value = record[key];
					// 	if (typeof value !== "undefined" && typeof key !== "undefined"){
					// 		text += key +  ": " + value + " - " + typeof(value) + "<br/>";
					// 	}
					// }
				}
			}
		},
		{title: "Delete",
			click: function(target, item, menu, colNum){
				var record;
				if(menu.callingListGrid.anySelected() && menu.callingListGrid.canEdit){
					record = menu.callingListGrid.getSelectedRecord();
					menu.callingListGrid.removeData(record);
				}
			}
		}
	]
});

isc.defineClass("myRefreshMenu", "myMenu").addProperties({
	parent: this,
	callingListGrid: null,
	data: [
		{title: "Refresh",
			click: function(target, item, menu, colNum){
				menu.callingListGrid.invalidateCache();
			}
		},
		{title: "Copy Row",
			click: function(target, item, menu, colNum){
				var record;
				var text = "";
				if(menu.callingListGrid.anySelected()){
					record = menu.callingListGrid.getSelectedRecord();
					isc.say(copyValues(record));
					// ToDo: Fix this so it only shows proper values.
					// for(var key in record) {
					// 	let value = record[key];
					// 	if (typeof value !== "undefined" && typeof key !== "undefined"){
					// 		text += key +  ": " + value + " - " + typeof(value) + "<br/>";
					// 	}
					// }
				}
			}
		}
	]
});

isc.defineClass("myChildMenu", "myMenu").addProperties({
	parent: this,
	callingListGrid: null,
	data: [
		{title: "Contacts",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				isc.MemberContacts.create({
					title: "Contacts for " + record.FullName,
					memberID: record.memberID,
					left: 190,
					top: 90
				});
			}
		},
		{title: "Dates",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				isc.MemberDates.create({
					title: "Activity for " + record.FullName,
					memberID: record.memberID,
					left: 150,
					top: 50
				});
			}
		},
		{title: "Edit Member",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				isc.EditMember.create({
					title: "Editing " + record.FullName,
					memberID: record.memberID,
					width: 400,
					height: 300,
					left: 210,
					top: 110
				});
			}
		},
		{title: "Leadership",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				isc.MemberChairs.create({
					title: "Leadership for " + record.FullName,
					memberID: record.memberID,
					left: 210,
					top: 110
				});
			}
		},
		{title: "Notes",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				isc.MemberNotes.create({
					title: "Notes for " + record.FullName,
					memberID: record.memberID,
					left: 170,
					top: 70
				});
			}
		},
		{title: "Refresh",
			click: function(target, item, menu, colNum){
				menu.callingListGrid.invalidateCache();
			}
		}
	]
});
isc.defineClass("myFullMenu", "myMenu").addProperties({
	parent: this,
	callingListGrid: null,
	data: [
		{title: "Contacts",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				isc.MemberContacts.create({
					title: "Contacts for " + record.FullName,
					memberID: record.memberID,
					left: 190,
					top: 90
				});
			}
		},
		{title: "Dates",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				isc.MemberDates.create({
					title: "Activity for " + record.FullName,
					memberID: record.memberID,
					autoFetch: true,
					left: 150,
					top: 50
				});
			}
		},
		{title: "Edit Member",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				isc.EditMember.create({
					title: "Editing " + record.FullName,
					memberID: record.memberID,
					width: 400,
					height: 300,
					left: 210,
					top: 110
				});
			}
		},
		{title: "Leadership",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				isc.MemberChairs.create({
					title: "Leadership for " + record.FullName,
					memberID: record.memberID,
					left: 210,
					top: 110
				});
			}
		},
		{title: "Notes",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				isc.MemberNotes.create({
					title: "Notes for " + record.FullName,
					memberID: record.memberID,
					left: 170,
					top: 70
				});
			}
		},
		{isSeparator: true},
		{title: "Add",
			click: function(target, item, menu, colNum){
				if(menu.callingListGrid.canEdit){
					menu.callingListGrid.startEditingNew();
				}
			}
		},
		{title: "Edit",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				var row = menu.callingListGrid.getRowNum(record);
				menu.callingListGrid.rowDoubleClick(record, row);
			}
		},
		{title: "Refresh",
			click: function(target, item, menu, colNum){
				menu.callingListGrid.invalidateCache();
			}
		},
		{title: "Delete",
			click: function(target, item, menu, colNum){
				var record;
				if(menu.callingListGrid.anySelected() && menu.callingListGrid.canEdit){
					record = menu.callingListGrid.getSelectedRecord();
					menu.callingListGrid.removeData(record);
				}
			}
		}
	]
});
isc.defineClass("myContactMenu", "myMenu").addProperties({
	parent: this,
	callingListGrid: null,
	data: [
		{title: "Add",
			click: function(target, item, menu, colNum){
				if(menu.callingListGrid.canEdit){
					menu.callingListGrid.startEditingNew();
				}
			}
		},
		{title: "Edit",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				var row = menu.callingListGrid.getRowNum(record);
				menu.callingListGrid.rowDoubleClick(row, record);
			}
		},
		{title: "Refresh",
			click: function(target, item, menu, colNum){
				menu.callingListGrid.invalidateCache();
			}
		},
		{title: "Delete",
			click: function(target, item, menu, colNum){
				var record;
				if(menu.callingListGrid.anySelected() && menu.callingListGrid.canEdit){
					record = menu.callingListGrid.getSelectedRecord();
					menu.callingListGrid.removeData(record);
				}
			}
		},
		{isSeparator: true},
		{title: "Show Contact Points",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				isc.BrewContactPoints.create({
					title: "Contact Points for " + record.contactName,
					contactID: record.contactID,
					width: 400,
					height: 200,
					left: 250,
					top: 150
				});
			}
		}
	]
});
isc.defineClass("myClubMenu", "myMenu").addProperties({
	parent: this,
	callingListGrid: null,
	data: [
		{title: "Add",
			click: function(target, item, menu, colNum){
				if(menu.callingListGrid.canEdit){
					menu.callingListGrid.startEditingNew();
				}
			}
		},
		{title: "Edit",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				var row = menu.callingListGrid.getRowNum(record);
				menu.callingListGrid.rowDoubleClick(record, row);
			}
		},
		{title: "Refresh",
			click: function(target, item, menu, colNum){
				menu.callingListGrid.invalidateCache();
			}
		},
		{title: "Delete",
			click: function(target, item, menu, colNum){
				var record;
				if(menu.callingListGrid.anySelected() && menu.callingListGrid.canEdit){
					record = menu.callingListGrid.getSelectedRecord();
					menu.callingListGrid.removeData(record);
				}
			}
		},
		{isSeparator: true},
		{title: "Attendance",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				isc.BrewAttendance.create({
					title: "Attendance for " + record.clubName,
					clubID: record.clubID,
					width: 600,
					height: 300,
					left: 190,
					top: 90
				});
			}
		},
		{title: "Contacts",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				isc.BrewContacts.create({
					title: "Contacts for " + record.clubName,
					clubID: record.clubID,
					width: 400,
					height: 200,
					left: 190,
					top: 90
				});
			}
		},
		{title: "Media",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				isc.BrewMedia.create({
					title: "Media for " + record.clubName,
					clubID: record.clubID,
					width: 500,
					height: 200,
					left: 190,
					top: 90
				});
			}
		}
	]
});
