CMS.registerPreviewTemplate('menu_items', ({ entry }) => {
    const data = entry.get('data').toJS();
    return `
      <div class="menu-card">
        <h3>${data.title}</h3>
        <p>Price: $${data.price}</p>
        <img src="${data.image}" alt="${data.title}" style="max-width: 200px;">
      </div>
    `;
  });
  
  CMS.registerPreviewStyle(`
    /* Add CMS preview styles here */
    body { padding: 20px; }
    .menu-card { border: 1px solid #ddd; padding: 15px; margin: 10px; }
  `);