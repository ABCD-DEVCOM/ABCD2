window.addEventListener('DOMContentLoaded', () => {
  const canvases = document.querySelectorAll('.protected-canvas');

  canvases.forEach(canvas => {
    const src = canvas.dataset.src;
    const ctx = canvas.getContext('2d');
    const img = new Image();
    img.crossOrigin = "anonymous";
    img.src = src;

    img.onload = () => {
      const maxWidth = 600;
      const scale = Math.min(1, maxWidth / img.width);
      const width = img.width * scale;
      const height = img.height * scale;

      canvas.width = width;
      canvas.height = height;

      ctx.drawImage(img, 0, 0, width, height);

      // Marca d'água
      const watermark = document.title; // Troque pelo nome desejado
      const fontSize = Math.floor(width / 15);
      ctx.font = `${fontSize}px Arial`;
      ctx.fillStyle = "rgba(255, 255, 255, 0.4)";
      ctx.textAlign = "center";
      ctx.textBaseline = "middle";

      ctx.save();
      ctx.translate(width / 2, height / 2);
      ctx.rotate(-Math.PI / 4); // 45 graus
      ctx.fillText(watermark, 0, 0);
      ctx.restore();
    };

    canvas.addEventListener("contextmenu", e => {
      e.preventDefault();
      alert("Imagem protegida.");
    });
  });
});
