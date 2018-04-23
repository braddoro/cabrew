isc.defineClass("BrewMedia", "myWindow").addProperties({
	title: "Brew Media",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.BrewMediaDS = isc.myDataSource.create({
			dataURL: serverPath + "BrewMedia.php",
			fields:[
				{name: "mediaID", primaryKey: true, type: "sequence", detail: true},
				{name: "clubID", detail: true, required: true},
				{name: "contactTypeID_fk", title: "Type", optionDataSource: isc.Shared.contactTypesDS, displayField: "contactType", valueField: "contactTypeID", width: 75},
				{name: "priority", width: 75},
				{name: "media",
					formatCellValue: function (value) {
						console.log(this.BrewMediaDS.name);
						var formatted;
						if (value) {
							formatted = "<a href='" + value + "' target='_blank'>" + value + "</a>";
						}
						return formatted;
					}
				}
			]
		});
		this.BrewMediaLG = isc.myListGrid.create({
			parent: this,
			name: "Brew Media",
			dataSource: this.BrewMediaDS,
			rowContextClick: function(record, rowNum, colNum){
				this.parent.localContextMenu.showContextMenu();
				return false;
			},
			startEditingNew: function(newValues, suppressFocus){
				var moreCriteria = isc.addProperties({}, newValues, {clubID: initData.clubID});
				return this.Super("startEditingNew", [moreCriteria, suppressFocus]);
			}
		});
		this.localContextMenu = isc.myContextMenu.create({
			parent: this,
			callingListGrid: this.BrewMediaLG
		});
		this.BrewMediaVL = isc.myVLayout.create({members: [this.BrewMediaLG]});
		this.addItem(this.BrewMediaVL);
		if(initData.clubID){
			this.BrewMediaLG.fetchData({clubID: initData.clubID});
		}
	}
});
