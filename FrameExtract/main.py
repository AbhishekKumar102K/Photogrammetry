import cv2
import os
import argparse
import logging
import sys


def var_of_laplacian(input_frame):
    return cv2.Laplacian(input_frame, cv2.CV_64F).var()


def parse_video():
    ap = argparse.ArgumentParser()
    ap.add_argument("-i", "--input", required=True, help="Path to Input Video")
    ap.add_argument("-o", "--output", required=True, help="Name of output directory")
    ap.add_argument("-t", "--threshold", required=False, type=float, default=100.0,
                    help="Threshold for filtering out blurry images, Images below this value will be removed. Default"
                         " is 100.0")
    args = vars(ap.parse_args())

    logging.basicConfig(level=logging.DEBUG)
    logger = logging.getLogger("Frame-Extractor")

    vs = cv2.VideoCapture(args["input"])

    try:
        os.mkdir(args["output"] + "/")
    except FileExistsError:
        logger.warning("\nFolder with name {} already exists, choose a different name.".format(args["output"]))
        sys.exit()

    if not vs.isOpened():
        print("File could not be opened")

    else:
        count = 0
        while vs.isOpened():
            ret, frame = vs.read()

            if ret:
                grey_frame = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
                logger.debug(var_of_laplacian(grey_frame))

                if var_of_laplacian(grey_frame) > args["threshold"]:
                    cv2.imwrite(args["output"] + "/" + "{}.jpg".format(count), frame)
                    count += 1

            else:
                break


if __name__ == "__main__":
    parse_video()