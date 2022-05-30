 $(document).ready(function() {
        $('#ajouterliste').click(function (e) {
            var nom = $('#listenom').val();

            if (nom !== '') {
                $.ajax({
                    url: '/liste',
                    type: "POST",
                    data: {nom: nom},
                    success: function (data) {

                    }
                })
            }
        })
    })

 $(document).ready(function() {
     $('.supprimerliste').click(function (e) {
         let listId = $(this).attr('data-listId')
         if (listId !== '') {
             $.ajax({
                 url: '/liste',
                 type: "DELETE",
                 data: {listId: listId},
                 success: function (data) {
                     $(location).attr('href', '/dashboard');


                 }
             })
         }
     })
 })

 $(document).ready(function() {
     $('#creertache').click(function (e) {
         var nom = $('#nomtache').val();
         var priority = $('#priorite_tache').val();
         var liste = $('#liste_tache').find(":selected").val();
         if (nom !== '') {
             $.ajax({
                 url: '/taches',
                 type: "POST",
                 data: {nom: nom, priority: priority, liste: liste},
                 success: function (data)  {

                 }
             })
         }
     })
 })



 $(document).ready(function() {
     $('.supprimertache').click(function (e) {
         let tacheId = $(this).attr('data-tacheId')
         if (tacheId !== '') {
             $.ajax({
                 url: '/taches',
                 type: "DELETE",
                 data: {tacheId: tacheId},
                 success: function (data) {
                     $(`#li-${tacheId}`).remove()
                 }
             })
         }
     e.preventDefault()
     })
 })

 $(document).ready(function() {
     $('.checkbox_task').each(function () {
         this.addEventListener('change', function () {
             $.ajax({
                 url: '/taches',
                 type: "PATCH",
                 data: {done: this.checked, tacheId: this.value},
                 success: function (data)  {

                 }
             });
         });
     })
 })