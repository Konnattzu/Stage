const dataset = [
	{
		id: "fileBlock",
		type: "block",
		items: [
			{
				type: "block",
				direction: "col",
				items: [
					{
						value: "File",
						id: "file",
						icon: "mdi mdi-file-outline",
						size: "small",
						ribbonHeight: "auto",
					},
					{
						type: "block",
						items: [
							{ id: "folder", icon: "mdi mdi-folder-outline" },
							{ id: "cloud", icon: "mdi mdi-weather-cloudy" },
						],
					},
				],
			},
			{
				id: "save",
				value: "Save",
				icon: "mdi mdi-content-save",
				size: "auto",
			},
		],
	},
	{
		type: "block",
		direction: "col",
		items: [
			{ id: "copy", icon: "mdi mdi-content-copy", value: "Copy" },
			{ id: "cut", icon: "mdi mdi-content-cut", value: "Cut" },
		],
	},
	{
		type: "block",
		items: [
			{
				type: "block",
				direction: "col",
				items: [
					{ id: "left", group: "align", value: "Left", icon: "mdi mdi-format-align-left" },
					{ id: "center", group: "align", value: "Center", icon: "mdi mdi-format-align-center" },
				],
			},
			{
				type: "block",
				direction: "col",
				items: [
					{ id: "right", group: "align", value: "Right", icon: "mdi mdi-format-align-right" },
					{ id: "justify", group: "align", value: "Justify", icon: "mdi mdi-format-align-justify" },
				],
			},
		],
	},
	{
		type: "block",
		items: [{ id: "download", value: "Download", icon: "dxi dxi-download", size: "auto" }],
	},
];
