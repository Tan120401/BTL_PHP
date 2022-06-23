
// handle control add, update, delete data

function handleRenderData(...params) {

    let formContainer = document.querySelector('.form-container')
    let formDelete = document.querySelector('.form-delete')
    let updateBtns = document.querySelectorAll('.update-btn')
    let deleteBtns = document.querySelectorAll('.delete-btn')

    deleteBtns.forEach(deleteBtn => deleteBtn.onclick = () => {
        formDelete.style.display = 'unset'
        document.querySelector('.form-delete__btn--yes').value = deleteBtn.closest('.table-row').children[0].innerText
    })

    document.querySelector('.form-delete__btn--no').onclick = () => formDelete.style.display = 'none'
    
    document.querySelector(".form").addEventListener("click", e => {
        e.stopPropagation();
    })

    formContainer.addEventListener("click", () => {
        formContainer.style.display = "none"
        params.forEach(param => {
                param.value = ''
        })
    })
    
    document.querySelector('.add-btn').onclick = () => {
        formContainer.style.display = 'unset'
        document.querySelector('.btn-submit').innerText = 'Thêm'
    }
    
    document.querySelector('.btn-cancel').onclick = () => {
        formContainer.style.display = "none"
        params.forEach(param => {
                param.value = ''
        })
    }
    
    updateBtns.forEach(updateBtn => updateBtn.onclick = () => {
        let row = updateBtn.closest('.table-row')
    
        formContainer.style.display = 'unset'
        document.querySelector('.btn-submit').innerText = 'Cập nhật'

        document.getElementById('id').name = 'id'
        document.getElementById('id').value = row.children[0].innerText

        params.forEach((param, index) => {
            param.value = row.children[index + 1].innerText
        })
    })

}

// handle caret menu user

function handleUserCaretIcon() {

    document.querySelector('.content__user').onclick = function() {
        let menuUser = document.querySelector('.content__user--menu')
        let caretUp = document.querySelector('.content__user--up')
        let caretDown = document.querySelector('.content__user--down')
    
        menuUser.classList.toggle('active')
        if (menuUser.classList.contains('active')) {
            caretDown.style.display = 'none'
            caretUp.style.display = 'inline-block'
        }
        else {
            caretDown.style.display = 'inline-block'
            caretUp.style.display = 'none'
        }
    }

}

export { handleRenderData, handleUserCaretIcon };