{"version":3,"sources":["script.js"],"names":["BX","namespace","UI","DropdownMenu","options","this","container","items","prototype","init","querySelectorAll","i","length","item","id","link","button","submenu","querySelector","operativeItem","getAttribute","push","classList","contains","activeItem","loadData","addItem","DropdownMenuItem","menu","resetItems","reset","resetSubItems","subItems","submenuOpen","newBadge","counter","isSubmenuExist","getToggleButton","appendChild","submenuVisibilityStateVisible","subItem","activeSubItem","showSubmenu","setNewToggleButtonName","addEvents","addSubItem","activate","add","remove","style","height","getSubmenuHeight","hideSubmenu","subItemsHeight","getHeight","addEventListener","e","preventDefault","setDefaultToggleButtonName","bind","buttonContainer","document","createElement","className","innerHTML","message","getNewItemBadge","itemBadgeNewContainer","getCounter","counterContainer","getAddItem","addItemContainer","setAddItemName","DropdownMenuSubItem","subMenu","offsetHeight"],"mappings":"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","file":"script.map.js"}