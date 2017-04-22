isc.defineClass("myContextMenu", "myMenu").addProperties({
	parent: this,
	callingListGrid: null,
	data: [
		{title: "Copy Row",
			click: function(target, item, menu, colNum){
				var record;
				var text = "";
				if(menu.callingListGrid.anySelected()){
					record = menu.callingListGrid.getSelectedRecord();
					for(var key in record) {
						let value = record[key];
						if (typeof value !== "undefined" && typeof key !== "undefined"){
							text += key +  ": " + value + " - " + typeof(value) + "<br/>";
						}
					}
					isc.say(text);
				}
			}
		},
		{title: "Add",
			click: function(target, item, menu, colNum){
				menu.callingListGrid.startEditingNew();
			}
		},
		{title: "Edit",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				var row = menu.callingListGrid.getRowNum(record);
				menu.callingListGrid.startEditing(row);
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
				if(menu.callingListGrid.anySelected()){
					record = menu.callingListGrid.getSelectedRecord();
					menu.callingListGrid.removeData({testID: record.testID});
				}
			}
		}
	]
});
isc.defineClass("myChildMenu", "myMenu").addProperties({
	parent: this,
	callingListGrid: null,
	data: [
		{title: "Show Dates",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				isc.MemberDates.create({
					title: "Activity for " + record.FullName,
					memberID: record.memberID,
					autoFetch: true,
					hideNames: true,
					width: 500,
					left: 150,
					top: 50
				});
			}
		},
		{title: "Show Notes",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				isc.MemberNotes.create({
					title: "Notes for " + record.FullName,
					memberID: record.memberID,
					width: 500,
					left: 170,
					top: 70
				});
			}
		},
		{title: "Show Contacts",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				isc.MemberContacts.create({
					title: "Contacts for " + record.FullName,
					memberID: record.memberID,
					width: 600,
					height: 300,
					left: 190,
					top: 90
				});
			}
		},
		{title: "Show Leadership",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				isc.MemberChairs.create({
					title: "Leadership for " + record.FullName,
					memberID: record.memberID,
					width: 600,
					height: 200,
					left: 210,
					top: 110
				});
			}
		}
	]
});
isc.defineClass("myFullMenu", "myMenu").addProperties({
	parent: this,
	callingListGrid: null,
	data: [
		{title: "Show Dates",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				isc.MemberDates.create({
					title: "Activity for " + record.FullName,
					memberID: record.memberID,
					autoFetch: true,
					hideNames: true,
					width: 500,
					left: 150,
					top: 50
				});
			}
		},
		{title: "Show Notes",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				isc.MemberNotes.create({
					title: "Notes for " + record.FullName,
					memberID: record.memberID,
					width: 500,
					left: 170,
					top: 70
				});
			}
		},
		{title: "Show Contacts",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				isc.MemberContacts.create({
					title: "Contacts for " + record.FullName,
					memberID: record.memberID,
					width: 600,
					height: 300,
					left: 190,
					top: 90
				});
			}
		},
		{title: "Show Leadership",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				isc.MemberChairs.create({
					title: "Leadership for " + record.FullName,
					memberID: record.memberID,
					width: 600,
					height: 200,
					left: 210,
					top: 110
				});
			}
		},
		{isSeparator: true},
		{title: "Copy Row",
			click: function(target, item, menu, colNum){
				var record;
				var text;
				if(menu.callingListGrid.anySelected()){
					record = menu.callingListGrid.getSelectedRecord();
					for(var key in record) {
						let value = record[key];
						if (typeof value !== "undefined" && typeof key !== "undefined"){
							text += key +  ": " + value + " - " + typeof(value) + "<br/>";
						}
					}
					isc.say(text);
				}
			}
		},
		{title: "Add",
			click: function(target, item, menu, colNum){
				menu.callingListGrid.startEditingNew();
			}
		},
		{title: "Edit",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				var row = menu.callingListGrid.getRowNum(record);
				menu.callingListGrid.startEditing(row);
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
				if(menu.callingListGrid.anySelected()){
					record = menu.callingListGrid.getSelectedRecord();
					menu.callingListGrid.removeData({testID: record.testID});
				}
			}
		}
	]
});
isc.defineClass("myContactMenu", "myMenu").addProperties({
	parent: this,
	callingListGrid: null,
	data: [
		{title: "Show Contact Types",
			click: function(target, item, menu, colNum){
				var record = menu.callingListGrid.getSelectedRecord();
				isc.BrewContactPoints.create({
					title: "Contact Types for " + record.contactName,
					contactID: record.contactID,
					width: 400,
					height: 200,
					left: 190,
					top: 90
				});
			}
		}
	]
});
isc.defineClass("myClubMenu", "myMenu").addProperties({
	parent: this,
	callingListGrid: null,
	data: [
		{title: "Show Contacts",
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
		{title: "Show Media",
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
