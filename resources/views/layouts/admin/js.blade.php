<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const toggle=document.getElementById('sidebarToggle'),sidebar=document.getElementById('adminSidebar');
if(toggle&&sidebar)toggle.addEventListener('click',()=>sidebar.classList.toggle('show'));
document.addEventListener('click',e=>{if(innerWidth<992&&sidebar&&toggle&&!sidebar.contains(e.target)&&!toggle.contains(e.target))sidebar.classList.remove('show')});
</script>
