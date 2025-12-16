document.addEventListener('DOMContentLoaded',()=>{
  const t=document.getElementById('toggleTheme');
  if(t){t.addEventListener('click',e=>{e.preventDefault();const dark=getComputedStyle(document.documentElement).getPropertyValue('--bg').trim();if(dark==='#0f172a'){document.documentElement.style.setProperty('--bg','#f8fafc');document.documentElement.style.setProperty('--card','#ffffff');document.documentElement.style.setProperty('--text','#0f172a');document.documentElement.style.setProperty('--accent','#2563eb');}else{document.documentElement.style.setProperty('--bg','#0f172a');document.documentElement.style.setProperty('--card','#111827');document.documentElement.style.setProperty('--text','#e5e7eb');document.documentElement.style.setProperty('--accent','#22c55e');}})}
});
