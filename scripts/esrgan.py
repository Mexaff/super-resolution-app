from PIL import Image
from RealESRGAN import RealESRGAN

def enhance_image(input_path, output_path):

    model = RealESRGAN('cuda', scale=4)
    model.load_weights('weights/RealESRGAN_x4.pth', download=True)

    img = Image.open(input_path).convert("RGB")
    sr_image = model.predict(img)
    sr_image.save(output_path)

if __name__ == "__main__":
    import argparse
    parser = argparse.ArgumentParser(description='Enhance image resolution using ESRGAN.')
    parser.add_argument('--input_image', required=True, help='Input path')
    parser.add_argument('--output_filename', required=True, help='Path to save the enhanced image.')
    args = parser.parse_args()

    enhance_image(args.input_image, args.output_filename)
