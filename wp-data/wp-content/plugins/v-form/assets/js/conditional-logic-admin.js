jQuery(function ($) {
    $(document).ready(function () {
      const logicContainer = $("#logic-container");

      // Function to toggle logic-combination visibility for a condition group
      function toggleLogicCombination(logicGroup) {
        // const conditionGroups = logicGroup.find(".condition-group");
        // if (conditionGroups.length <= 1) {
        //   logicGroup.find(".logic-combination").hide();
        // } else {
        // }
        logicGroup.find(".logic-combination").show();
      }

      // Add a new conditional logic group
      $("#add-logic-group").click(function () {
        const newLogicGroup = `
          <div class="logic-group">
            <h3>Conditional Logic Group</h3>
            <input name="logic_name" type="text" placeholder="Logic Group Name">
            <div class="condition-group-container"></div>
            <button class="add-condition">Add Condition</button>
            <label>Actions:</label>
            <table class="kb-logic-field-table">
              <thead>
                <tr>
                  <th>Field</th>
                  <th>Hide</th>
                </tr>
              </thead>
              <tbody>
              `+getfieldhide()+`
              </tbody>
            </table>
            <button class="remove-logic-group">Remove Logic Group</button>
          </div>`;
        logicContainer.append(newLogicGroup);

        $('#save-logic').show();
      });

      // Add a new condition to a logic group
      $(document).on("click", ".add-condition", function () {
        const logicGroup = $(this).closest(".logic-group");
        const newCondition = `
          <div class="condition-group">
            <select class="mylogicfield">
              <option>Select Field</option>
              `+getselectfields()+`
            </select>
            <select class="condition-operator">
              <option>Select State</option>
              <option value="equals">Is equal to</option>
              <option value="not_equals">Is not equal to</option>
              <option value="contains">Contains</option>
              <option value="not_contains">Does not contain</option>
            </select>
            <input name="condition_value" type="text"  placeholder="Type a value">
            <select class="logic-combination">
              <option value="and">AND</option>
              <option value="or">OR</option>
            </select>
            <button class="remove-condition">Remove</button>
          </div>`;
        logicGroup.find(".condition-group-container").append(newCondition);
        toggleLogicCombination(logicGroup);
      });

      // Remove a condition
      $(document).on("click", ".remove-condition", function () {
        const logicGroup = $(this).closest(".logic-group");
        $(this).closest(".condition-group").remove();
        toggleLogicCombination(logicGroup);
      });

      // Remove a logic group
      $(document).on("click", ".remove-logic-group", function () {
      const $group = $(this).closest(".logic-group");
      const logicId = $(this).data("id");

      if(!logicId){
        $group.remove();
      }else{
        if (confirm('Are you sure?') && logicId) {
            // Send AJAX request to delete from database
            $.post(ajax_object, {
                action: "delete_field_logic_group",
                logic_id: logicId
            }).done(function (response) {
                if (response.success) {
                    $group.remove(); // Remove from DOM after successful deletion
                    Toast("Logic group deleted successfully!", "toast-success");
                } else {
                    Toast("Error deleting logic group", "toast-danger");
                }
            });
        } 
      }

    });


      // Save logic
      $("#save-logic").click(function () {
        const logicGroups = [];
        const formId = $("#vfromid").val();

        $(".logic-group").each(function () {
            const logicId = $(this).data("id") || 0; // <-- get logic ID from data-id attribute
            const logicName = $(this).find("input[name='logic_name']").val();
            const conditions = [];

            $(this).find(".condition-group").each(function () {
                const field = $(this).find(".mylogicfield").val();
                const operator = $(this).find(".condition-operator").val();
                const value = $(this).find("input[name='condition_value']").val();
                const combination = $(this).find(".logic-combination").val();
                conditions.push({ field, operator, value, combination });
            });

            const hiddenFields = [];
            $(this).find(".kb-logic-field-table tbody input[type='checkbox']:checked").each(function () {
                hiddenFields.push($(this).data("field"));
            });

            logicGroups.push({ id: logicId, logicName, conditions, hiddenFields }); // <-- include ID
        });

        // AJAX request to save the logic groups
        $.post(ajax_object, {
            action: "save_field_logic_groups",
            form_id: formId,
            logic_groups: JSON.stringify(logicGroups),
        }).done(function (response) {
            // console.log(response.message);
            window.location.reload();
        });
     });




      function getselectfields(){
        var seloptin = '';
            $(".vform-group").each(function(){
                var firstElementWithName = $(this).find('[name]').first();
                var getprid = $(this).data('batchid');
                var strfrm = $(this).data('type');
                var labletext = $(this).children('label').text();
                labletext = labletext.replace('*','');
                if(labletext==''){
                  labletext = strfrm;
                }
                if(strfrm!='' && strfrm!=undefined && strfrm!='submit'){
                  var getfull = $(firstElementWithName).attr('name');
                    if(getfull!=undefined){ 
                      seloptin+= "<option value='"+getfull+"'>"+labletext+"</option>";
                    }
                }
            });
            return seloptin;
      }

      function getfieldhide(){
        var seloptin = '';
            $(".vform-group").each(function(){
              var firstElementWithName = $(this).find('[name]').first();
              var getprid = $(this).data('batchid');
                var strfrm = $(this).data('type');
                var labletext = $(this).children('label').text();
                labletext = labletext.replace('*','');
                if(labletext==''){
                  labletext = strfrm
                }
                if(strfrm!='' && strfrm!=undefined && strfrm!='submit'){
                  seloptin+= "<tr><td>"+labletext+"</td><td><input type='checkbox' data-field='vform-group-vform"+getprid+"'></td></tr>";
                }              
            });
            return seloptin;
      }

      let animating = false;

      function Toast(message, messagetype) {
        var cont = document.getElementById("toast-container");
        cont.classList.add("show"); // correct manipulation
        var type = document.getElementById("toast-type");
        type.className += " " + messagetype;
        var x = document.getElementById("snackbar");
        x.innerHTML = message;
        setTimeout(function() {
          cont.classList.remove("show"); // access it again here
          animating = false;
        }, 3000);
      }


    });
  });




  jQuery(function ($) {

    $(document).ready(function () {

      function getselectfields(selectedField = '') {
        var seloptin = '';
        $(".vform-group").each(function () {
          var firstElementWithName = $(this).find('[name]').first();
          var getprid = $(this).data('batchid');
          var strfrm = $(this).data('type');
          var labletext = $(this).children('label').text().replace('*', '');
          if(labletext==''){
            labletext = strfrm;
          }
          if (strfrm && strfrm !== 'submit') {
            var getfull = $(firstElementWithName).attr('name');
            var selected = getfull === selectedField ? 'selected' : '';
            if(getfull!=undefined){
              seloptin += `<option value="${getfull}" ${selected}>${labletext}</option>`;
            }
          }
        });
        return seloptin;
      }

      function getfieldhide(hiddenFields = []) {
        var seloptin = '';
        $(".vform-group").each(function () {
          var getprid = $(this).data('batchid');
          var strfrm = $(this).data('type');
          var labletext = $(this).children('label').text().replace('*', '');
          if(labletext==''){
            labletext = strfrm
          }
          if (strfrm && strfrm !== 'submit') {
            var fieldKey = 'vform-group-vform' + getprid;
            var checked = hiddenFields.includes(fieldKey) ? 'checked' : '';
            seloptin += `<tr><td>${labletext} (#${getprid})</td><td><input type="checkbox" data-field="${fieldKey}" ${checked}></td></tr>`;
          }
        });
        return seloptin;
      }

      function toggleLogicCombination(logicGroup) {
        // const conditionGroups = logicGroup.find(".condition-group");
        // if (conditionGroups.length <= 1) {
        //   logicGroup.find(".logic-combination").hide();
        // } else {
          // }

            logicGroup.find(".logic-combination").show();
      }


          // Load existing logic groups on page load
      function loadSavedLogicGroups() {
        const savedGroups = logicData.logicGroups;
        const formId = $("#vfromid").val();
        const logicContainer = $("#logic-container");

        if (!savedGroups || !Array.isArray(savedGroups)) return;

        savedGroups.forEach(function (group) {
          if (parseInt(group.form_id) !== parseInt(formId)) return;

          const logicGroup = $(`
            <div class="logic-group" data-id="${group.id}">
              <h3>Conditional Logic Group</h3>
              <input name="logic_name" type="text" placeholder="Logic Group Name" value="${group.logic_name}">
              <div class="condition-group-container"></div>
              <button class="add-condition">Add Condition</button>
              <label>Actions:</label>
              <table class="kb-logic-field-table">
                <thead>
                  <tr>
                    <th>Field</th>
                    <th>Hide</th>
                  </tr>
                </thead>
                <tbody>
                  ${getfieldhide(group.hidden_fields)}
                </tbody>
              </table>
              <button class="remove-logic-group" data-id="${group.id}">Remove Logic Group</button>
            </div>
          `);

          const conditionContainer = logicGroup.find(".condition-group-container");

          if (Array.isArray(group.conditions)) {
            group.conditions.forEach((cond, index) => {
              const conditionGroup = $(`
                <div class="condition-group">
                  <select class="mylogicfield">
                    <option>Select Field</option>
                    ${getselectfields(cond.field)}
                  </select>
                  <select class="condition-operator">
                    <option>Select State</option>
                    <option value="equals">Is equal to</option>
                    <option value="not_equals">Is not equal to</option>
                    <option value="contains">Contains</option>
                    <option value="not_contains">Does not contain</option>
                  </select>
                  <input name="condition_value" type="text" placeholder="Type a value" value="${cond.value || ''}">
                  <select class="logic-combination">
                    <option value="and">AND</option>
                    <option value="or">OR</option>
                  </select>
                  <button class="remove-condition">Remove</button>
                </div>
              `);

              conditionGroup.find(".mylogicfield").val(cond.field);
              conditionGroup.find(".condition-operator").val(cond.operator);
              conditionGroup.find(".logic-combination").val(cond.combination);

              conditionContainer.append(conditionGroup);
            });
          }

          // Toggle visibility of AND/OR dropdowns
          toggleLogicCombination(logicGroup);

          logicContainer.append(logicGroup);
        });
      }


      // Call it on document ready
      loadSavedLogicGroups();


      if ($.trim($('#logic-container').html()) != ''){
        $('#save-logic').show();
      }



    });

  });