(function () {
    "use strict";
  
    new Sortable(kanbanscroll, {
      swapThreshold: 1,
      animation: 150,
    });
  
    new Sortable(childsort, {
      swapThreshold: 1,
      animation: 150,
    });
  
    new Sortable(childsort2, {
      swapThreshold: 1,
      animation: 150,
    });
    new Sortable(childsort3, {
      swapThreshold: 1,
      animation: 150,
    });
  
    new Sortable(childsort4, {
      swapThreshold: 1,
      animation: 150,
    });

  
    let index = 0;
    document.querySelector("#addboard").onclick = () => {
      let element = `
          <div class="kanban-tasks-type default">
              <div class="pe-3 mb-3">
                  <div class="d-flex justify-content-between align-items-center">
                      <span class="d-block fw-semibold editable-text fs-15">New Board</span>
                      <div class="d-flex align-items-center gap-2">
                        <a aria-label="anchor" href="#addtask" class="btn btn-sm bg-white text-default border-0 btn-wave" data-bs-toggle="offcanvas" aria-controls="addtask">
                            <i class="ri-add-line align-middle me-1 fw-semibold"></i>Add Task
                        </a>
                        <div class="dropdown">
                            <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-sm bg-white text-default" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fe fe-more-vertical"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-eye-line me-1 align-middle d-inline-block"></i>Rename Board</a></li>
                                <li><a class="delete-board dropdown-item" href="javascript:void(0);"><i class="ri-delete-bin-line me-1 align-middle d-inline-block"></i>Delete</a></li>
                            </ul>
                        </div>
                    </div>
                  </div>
              </div>
              <div class="kanban-tasks" id="default-tasks">
                  <div id="default-tasks-draggable" class="dragable-container" data-view-btn="default-tasks">
                  </div>
              </div>
          </div>`;
      document.querySelector(".NILOVA-kanban-board").innerHTML += element;
      index = index + 1;
      document.querySelectorAll(".delete-board").forEach((element) => {
        element.addEventListener("click", delBoard2);
      });
      const editableElements2 = document.querySelectorAll(".editable-text");
      editableElements2.forEach(function (editableContent2) {
        editableContent2.addEventListener("click", function () {
          editableContent2.contentEditable = true;
          editableContent2.focus();
          editableContent2.classList.add("clicked");
        });
        editableContent2.addEventListener("blur", function () {
          const editedText = editableContent2.innerHTML;
          editableContent2.contentEditable = false;
          editableContent2.classList.remove("clicked");
        });
      });
    };
  
    document.querySelectorAll(".delete-board").forEach((element) => {
      let i = document.querySelectorAll(".delete-board").length;
  
      element.addEventListener("click", delBoard2);
    });
  
    function delBoard2() {
      Swal.fire({
        title: "Are you sure?",
        text: "You want Delete This Board",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--primary-color)",
        cancelButtonColor: "#d33",
        confirmButtonText: "Remove",
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire("Removed", "The Board Is successfully Removed", "success");
          let delboard = this.closest(".kanban-tasks-type");
          delboard.remove();
        }
      });
    }
  
    document.querySelectorAll(".delete-task-main").forEach((element) => {
      let i = document.querySelectorAll(".delete-task-main").length;
  
      element.onclick = () => {
        Swal.fire({
          title: "Are you sure?",
          text: "You want Delete This Board",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "var(--primary-color)",
          cancelButtonColor: "#d33",
          confirmButtonText: "Remove",
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire("Removed", "The Board Is successfully Removed", "success");
            let delboard = element.closest(".custom-card");
            delboard.remove();
            i = document.querySelectorAll(".delete-task-main").length;
          }
        });
      };
    });
  
    var drake = dragula({
      isContainer: function (el) {
        return el.classList.contains("dragable-container");
      },
    });
    setInterval(() => {
      let containerClass = ".dragable-container"; // Replace with your actual class name
      document.querySelectorAll(containerClass).forEach((ele) => {
        if (ele) {
          if (ele.children.length === 0) {
            // If container has no children, add classes
            ele.classList.add("task-Null");
            if (document.querySelector(".view-more-button") == "true") {
              document
                .querySelector(`#${ele.getAttribute("data-view-btn")}`)
                .nextElementSibling.classList.add("d-none");
            }
          } else {
            // If container has children, remove classes
            ele.classList.remove("task-Null");
            if (document.querySelector(".view-more-button") == "true") {
              document
                .querySelector(`#${ele.getAttribute("data-view-btn")}`)
                .nextElementSibling.classList.remove("d-none");
            }
          }
        }
      });
    }, 100);
  
    const choicesMulti = ".choices-multiple-remove-button";
    const dropdowns = document.querySelectorAll(choicesMulti);
    dropdowns.forEach((dropdown) => {
      new Choices(dropdown, {
        allowHTML: true,
        removeItemButton: true,
        searchEnabled: true, // Enable typed text/search functionality
        paste: false,
        duplicateItemsAllowed: false,
        editItems: true,
      });
    });
  
    var targetDateInputs = document.querySelectorAll(".targetDate2");
    targetDateInputs.forEach(function (input) {
      flatpickr(input, {
        enableTime: true,
        dateFormat: "y-m-d, H:i",
      });
    });
  
    /* filepond */
    FilePond.registerPlugin(
      FilePondPluginImagePreview,
      FilePondPluginImageExifOrientation,
      FilePondPluginFileValidateSize,
      FilePondPluginFileEncode,
      FilePondPluginImageEdit,
      FilePondPluginFileValidateType,
      FilePondPluginImageCrop,
      FilePondPluginImageResize,
      FilePondPluginImageTransform
    );
    const filepondElements = document.querySelectorAll(".multiple-filepond");
    filepondElements.forEach((element) => {
      FilePond.create(element);
    });
  
    var toolbarOptions = [
      [{ header: [1, 2, 3, 4, 5, 6, false] }],
      [{ font: [] }],
      ["bold", "italic", "underline", "strike"], // toggled buttons
      ["blockquote", "code-block"],
  
      [{ header: 1 }, { header: 2 }], // custom button values
      [{ list: "ordered" }, { list: "bullet" }],
      [{ script: "sub" }, { script: "super" }], // superscript/subscript
      [{ indent: "-1" }, { indent: "+1" }], // outdent/indent
      [{ direction: "rtl" }], // text direction
  
      [{ size: ["small", false, "large", "huge"] }], // custom dropdown
  
      [{ color: [] }, { background: [] }], // dropdown with defaults from theme
      [{ align: [] }],
  
      ["image", "video"],
      ["clean"], // remove formatting button
    ];
    const editorElements = document.querySelectorAll(".editor");
    class QuillEditor {
      constructor(element) {
        this.quill = new Quill(element, {
          modules: {
            toolbar: toolbarOptions, // Assuming toolbarOptions is defined elsewhere
          },
          theme: "snow",
        });
      }
    }
    editorElements.forEach((element) => new QuillEditor(element));
  
    const values = [
      {
        value: "1",
        label:
          'Angelina May',
        id: 1,
      },
      {
        value: "2",
        label:
          'Kiara advain',
        id: 2,
      },
      {
        value: "3",
        label:
          'Hercules Jhon',
        id: 3,
      },
      {
        value: "4",
        label:
          'Mayor Kim',
        id: 4,
      },
      {
        value: "5",
        label:
          'Jhon May',
        id: 5,
      },
      {
        value: "6",
        label:
          'Alexa Biss',
        id: 6,
      },
      {
        value: "7",
        label:
          'Karley Dia',
        id: 7,
      },
      {
        value: "8",
        label:
          'Kim Jong',
        id: 8,
      },
      {
        value: "9",
        label:
          'Darren Sami',
        id: 9,
      },
      {
        value: "10",
        label:
          'Elizabeth',
        id: 10,
      },
      {
        value: "11",
        label:
          'Bear Gills',
        id: 11,
      },
      {
        value: "12",
        label:
          'Alex Carey',
        id: 12,
      },
    ];
    const values2 = [
      {
        value: "1",
        label: "TODO",
        id: 1,
      },
      {
        value: "2",
        label: "IN-PROGRESS",
        id: 2,
      },
      {
        value: "3",
        label: "REVIEW",
        id: 3,
      },
      {
        value: "4",
        label: "COMPLETED",
        id: 4,
      },
      {
        value: "5",
        label: "UAT",
        id: 5,
      },
      {
        value: "6",
        label: "QA",
        id: 6,
      },
      {
        value: "7",
        label: "DONE",
        id: 7,
      },
    ];
    const selectedValues = ["2", "3", "5"];
    // const element = document.querySelector("#choices-images");
    // const choices = new Choices(element, {
    //   choices: values,
    //   allowHTML: true,
    //   removeItemButton: true,
    // });
  
    const elements = document.querySelectorAll(".choices-images");
    elements.forEach(function (element) {
      const choices = new Choices(element, {
        choices: values,
        multiple: true,
      });
  
      // Manually select options
      choices.setChoiceByValue(selectedValues);
    });
    const elements2 = document.querySelectorAll(".status-choices");
    elements2.forEach(function (elements2) {
      const choices = new Choices(elements2, {
        choices: values,
        multiple: true,
      });
  
      // Manually select options
      choices.setChoiceByValue(selectedValues);
    });
  
    var targetDateInputs = document.querySelectorAll(".targetDate");
    targetDateInputs.forEach(function (input) {
      flatpickr(input, {
        mode: "range",
        enableTime: true,
        dateFormat: "Y F-d, H:i",
      });
    });
    var targetDateInputs = document.querySelectorAll(".targetDate3");
    targetDateInputs.forEach(function (input) {
      flatpickr(input, { enableTime: true, dateFormat: "Y F-d, H:i" });
    });
  
    document.querySelector("#addchildtask").onclick = () => {
      let element = `
      <div class="d-sm-flex p-sm-0 p-3 align-items-center bg-light mt-2 rounded-3 childtask flex-wrap">
        <div class="child-left">
            <select class="form-control" data-trigger>
                <option value="1">Project-1</option>
                <option value="2" selected>Project-2</option>
                <option value="3">Project-3</option>
                <option value="4">Project-4</option>
                <option value="5">Project-5</option>
                <option value="6">Project-6</option>
                <option value="7">Project-7</option>
            </select>
            <input type="text" class="form-control bg-transparent border-0" placeholder="App Title">
        </div>
        <div class="child-right">
            <input type="text" class="text-end form-control bg-transparent border-0 w-auto targetDate3" placeholder="Due Date">
            <select class="form-control choices-images" name="choices-images3">
            </select>
            <select class="form-control status-choices"></select>
            <div class="px-3">
                <button aria-label="button" type="button" class="btn-sm btn-icon btn btn-danger delete-task"><i class="fe fe-trash-2"></i></button>
                <button aria-label="button" type="button" class="btn-sm btn-icon btn btn-info">
                <i class="ri-eye-line"></i></button>
            </div>
        </div>
    </div>`;
      document
        .querySelector("#childsort")
        .insertAdjacentHTML("beforeend", element);
      let addedElement = document.querySelector("#childsort").lastElementChild;
      new Choices(addedElement.querySelector(".choices-images"), {
        choices: values,
      });
      new Choices(addedElement.querySelector(".status-choices"), {
        choices: values2,
      });
      new Choices(addedElement.querySelector("[data-trigger]"), {
        allowHTML: true,
        placeholder: true,
        placeholderValue: "This is a placeholder set in the config",
        searchPlaceholderValue: "Search",
      });
      flatpickr(addedElement.querySelector(".targetDate3"), {
        enableTime: true,
        dateFormat: "Y F-d, H:i",
      });
  
      // Add delete task functionality
      addedElement.querySelector(".delete-task").onclick = () => {
        Swal.fire({
          title: "Are you sure?",
          text: "You want to delete this task",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "var(--primary-color)",
          cancelButtonColor: "#d33",
          confirmButtonText: "Remove",
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire("Removed", "The task is successfully removed", "success");
            let deltask = addedElement; // Use addedElement instead of element
            deltask.remove();
          }
        });
      };
    };
  
    document.querySelector("#addchildtask2").onclick = () => {
      let element = `
      <div class="d-sm-flex p-sm-0 p-3 align-items-center bg-light mt-2 rounded-3 childtask flex-wrap">
        <div class="child-left">
            <select class="form-control" data-trigger>
                <option value="1">Project-1</option>
                <option value="2" selected>Project-2</option>
                <option value="3">Project-3</option>
                <option value="4">Project-4</option>
                <option value="5">Project-5</option>
                <option value="6">Project-6</option>
                <option value="7">Project-7</option>
            </select>
            <input type="text" class="form-control bg-transparent border-0" placeholder="App Title">
        </div>
        <div class="child-right">
            <input type="text" class="text-end form-control bg-transparent border-0 w-auto targetDate3" placeholder="Due Date">
            <select class="form-control choices-images" name="choices-images4">
            </select>
            <select class="form-control status-choices"></select>
            <div class="px-3">
            <button aria-label="button" type="button" class="btn-sm btn-icon btn btn-danger delete-task"><i class="fe fe-trash-2"></i></button>
            <button aria-label="button" type="button" class="btn-sm btn-icon btn btn-info">
              <i class="ri-eye-line"></i></button>
            </div>
        </div>
    </div>`;
      document
        .querySelector("#childsort2")
        .insertAdjacentHTML("beforeend", element);
      let addedElement = document.querySelector("#childsort2").lastElementChild;
      new Choices(addedElement.querySelector(".choices-images"), {
        choices: values,
      });
      new Choices(addedElement.querySelector(".status-choices"), {
        choices: values2,
      });
      new Choices(addedElement.querySelector("[data-trigger]"), {
        allowHTML: true,
        placeholder: true,
        placeholderValue: "This is a placeholder set in the config",
        searchPlaceholderValue: "Search",
      });
      flatpickr(addedElement.querySelector(".targetDate3"), {
        enableTime: true,
        dateFormat: "Y F-d, H:i",
      });
  
      // Add delete task functionality
      addedElement.querySelector(".delete-task").onclick = () => {
        Swal.fire({
          title: "Are you sure?",
          text: "You want to delete this task",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "var(--primary-color)",
          cancelButtonColor: "#d33",
          confirmButtonText: "Remove",
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire("Removed", "The task is successfully removed", "success");
            let deltask = addedElement; // Use addedElement instead of element
            deltask.remove();
          }
        });
      };
    };
  
    document.querySelector("#addchildtask3").onclick = () => {
      let element = `
      <div class="d-sm-flex p-sm-0 p-3 align-items-center bg-light mt-2 rounded-3 childtask flex-wrap">
        <div class="child-left">
            <select class="form-control" data-trigger>
                <option value="1">Project-1</option>
                <option value="2" selected>Project-2</option>
                <option value="3">Project-3</option>
                <option value="4">Project-4</option>
                <option value="5">Project-5</option>
                <option value="6">Project-6</option>
                <option value="7">Project-7</option>
            </select>
            <input type="text" class="form-control bg-transparent border-0" placeholder="App Title">
        </div>
        <div class="child-right">
            <input type="text" class="text-end form-control bg-transparent border-0 w-auto targetDate3" placeholder="Due Date">
            <select class="form-control choices-images" multiple>
            </select>
            <select class="form-control status-choices"></select>
            <div class="px-3">
                <button aria-label="button" type="button" class="btn-sm btn-icon btn btn-danger delete-task"><i class="fe fe-trash-2"></i></button>
                <button aria-label="button" type="button" class="btn-sm btn-icon btn btn-info">
                <i class="ri-eye-line"></i></button>
            </div>
        </div>
    </div>`;
      document
        .querySelector("#childsort3")
        .insertAdjacentHTML("beforeend", element);
      let addedElement = document.querySelector("#childsort3").lastElementChild;
      new Choices(addedElement.querySelector(".choices-images"), {
        choices: values,
      });
      new Choices(addedElement.querySelector(".status-choices"), {
        choices: values2,
      });
      new Choices(addedElement.querySelector("[data-trigger]"), {
        allowHTML: true,
        placeholder: true,
        placeholderValue: "This is a placeholder set in the config",
        searchPlaceholderValue: "Search",
      });
      flatpickr(addedElement.querySelector(".targetDate3"), {
        enableTime: true,
        dateFormat: "Y F-d, H:i",
      });
  
      // Add delete task functionality
      addedElement.querySelector(".delete-task").onclick = () => {
        Swal.fire({
          title: "Are you sure?",
          text: "You want to delete this task",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "var(--primary-color)",
          cancelButtonColor: "#d33",
          confirmButtonText: "Remove",
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire("Removed", "The task is successfully removed", "success");
            let deltask = addedElement; // Use addedElement instead of element
            deltask.remove();
          }
        });
      };
    };
  
    document.querySelector("#addchildtask4").onclick = () => {
      let element = `
      <div class="d-sm-flex p-sm-0 p-3 align-items-center bg-light mt-2 rounded-3 childtask flex-wrap">
        <div class="child-left">
            <select class="form-control" data-trigger>
                <option value="1">Project-1</option>
                <option value="2" selected>Project-2</option>
                <option value="3">Project-3</option>
                <option value="4">Project-4</option>
                <option value="5">Project-5</option>
                <option value="6">Project-6</option>
                <option value="7">Project-7</option>
            </select>
            <input type="text" class="form-control bg-transparent border-0" placeholder="App Title">
        </div>
        <div class="child-right">
            <input type="text" class="text-end form-control bg-transparent border-0 w-auto targetDate3" placeholder="Due Date">
            <select class="form-control choices-images" multiple>
            </select>
            <select class="form-control status-choices"></select>
            <div class="px-3">
            <button aria-label="button" type="button" class="btn-sm btn-icon btn btn-danger delete-task"><i class="fe fe-trash-2"></i></button>
            <button aria-label="button" type="button" class="btn-sm btn-icon btn btn-info">
              <i class="ri-eye-line"></i></button>
            </div>
        </div>
    </div>`;
      document
        .querySelector("#childsort4")
        .insertAdjacentHTML("beforeend", element);
      let addedElement = document.querySelector("#childsort4").lastElementChild;
      new Choices(addedElement.querySelector(".choices-images"), {
        choices: values,
      });
      new Choices(addedElement.querySelector(".status-choices"), {
        choices: values2,
      });
      new Choices(addedElement.querySelector("[data-trigger]"), {
        allowHTML: true,
        placeholder: true,
        placeholderValue: "This is a placeholder set in the config",
        searchPlaceholderValue: "Search",
      });
      flatpickr(addedElement.querySelector(".targetDate3"), {
        enableTime: true,
        dateFormat: "Y F-d, H:i",
      });
  
      // Add delete task functionality
      addedElement.querySelector(".delete-task").onclick = () => {
        Swal.fire({
          title: "Are you sure?",
          text: "You want to delete this task",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "var(--primary-color)",
          cancelButtonColor: "#d33",
          confirmButtonText: "Remove",
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire("Removed", "The task is successfully removed", "success");
            let deltask = addedElement; // Use addedElement instead of element
            deltask.remove();
          }
        });
      };
    };
  
    var myButtons = document.querySelectorAll(".publicview");
    var eyeIcons = document.querySelectorAll(".eyeIcon");
    myButtons.forEach(function (button, index) {
      // Assign the corresponding eyeIcon for each button
      var eyeIcon = eyeIcons[index];
  
      // Add a click event listener to each button
      button.addEventListener("click", function () {
        // Toggle between ri-lock-line and ri-lock-unlock-line classes
        eyeIcon.classList.toggle("ri-lock-line");
        eyeIcon.classList.toggle("ri-lock-unlock-line");
      });
    });
  
    const lightbox = GLightbox({
      selector: ".gallery a",
      touchNavigation: true,
      loop: true,
      zoomable: true,
      closeOnOutsideClick: true,
      closeOnEscapeKey: true,
    });
  
  })();
  
  function replay() {
    "use strict";
  
    let replayButtons = document.querySelectorAll(".reply");
  
    replayButtons.forEach((element) => {
      element.addEventListener("click", () => {
        let parentDiv = element.parentElement;
  
        // Check if a comment box already exists in the parent element
        if (!parentDiv.querySelector(".comment")) {
          // Create a div element
          let commentDiv = document.createElement("div");
          commentDiv.classList = "comment mt-3 d-grid";
  
          // Create a textarea element
          let element = ` <div class="comment-section position-relative">
                <textarea class="form-control" id="comment-area" rows="1" placeholder="Write Your Comment Here"></textarea>
                <div class="comment-files">
                    <a aria-label="anchor" href="javascript:void(0);" class="comment-icon position-relative"><input type="file" class="position-absolute w-100 h-100 op-0" id="profile-change"> <i class="ri-attachment-2"></i></a>
                    <a aria-label="anchor" href="javascript:void(0);" class="comment-icon"><i class="ri-send-plane-2-line"></i></a>
                    <a aria-label="anchor" href="javascript:void(0);" class="comment-icon text-danger cancel-btn"><i class="ri-close-line"></i></a>
                </div>
            </div>`;
  
          // Append elements to the comment div
          commentDiv.innerHTML += element;
  
          // Append the comment div to the parent element
          parentDiv.appendChild(commentDiv);
          let cancelButtons = document.querySelectorAll(".cancel-btn");
  
          // Add a click event listener to each cancel button
          cancelButtons.forEach((cancelButton) => {
            cancelButton.addEventListener("click", () => {
              // Assuming parentDiv is defined earlier in your code
              parentDiv.removeChild(commentDiv);
            });
          });
        }
      });
    });
  }
  replay();
  
  document.addEventListener("DOMContentLoaded", function () {
    var checkboxes = document.querySelectorAll(".form-check-input");
    var badge = document.getElementById("sprint-icon-badge");
  
    checkboxes.forEach(function (checkbox) {
      checkbox.addEventListener("change", function () {
        var checkedCheckboxes = document.querySelectorAll(
          ".form-check-input:checked"
        );
        var checkedCount = checkedCheckboxes.length;
  
        if (checkedCount > 0) {
          badge.classList.remove("d-none");
          badge.textContent = checkedCount;
        } else {
          badge.classList.add("d-none");
        }
      });
    });
  
  });
  