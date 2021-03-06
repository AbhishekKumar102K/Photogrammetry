# Algorithms Involved

## Structure from Motion
Takes some images as input and outputs the camera parameters of each image as well as a rough 3D shape of the scene, often called the sparse point cloud. This is done by identifying features in each input image and matching these features between different pairs of images. The feature identification and matching step is crucial in photogrammetry and is hugely dependent on the percentage overlap between consecutive images. When many matches are found, a 3D transformation matrix can be computed, which effectively gives the related 3D position between the camera poses. As SfM is performing a 3D reconstruction using the feature points, the vertices of the 3D scene will be located at those unique points, thus, producing a rough 3D shape as output.

## Multi View Stereo
In this step, the MVS algorithm is used for refining the mesh obtained by the SfM technique, which produces a Dense reconstruction or a Dense Point Cloud. This algorithm needs the camera parameters of the images to work, which are given by the output of the SfM algorithm. MVS then computes the 3D vectors on areas which could not be correctly detected by the feature detection algorithm during SfM. This is possible because since we know the camera parameters, we know a given pixel in one image is the projection of a line in some other image. This approach is called epipolar geometry. Compared to SfM, which had to search the entire 2D image for matching features, MVS works on a single 1D line to find matches, thereby, simplifying the problem quite a lot.




# Steps
##  Feature Detection and Matching 
This is done by using the OpenMVG library. It takes in pairs of images and identifies the common features between them. This is done by using a technique known as Scale Invariant Feature Transform (SIFT). This step works best if the percentage overlap between two consecutive images (in the image sequence) is at least 80-85%. It then plots these common feature points in 3D space and generates a Sparse Point Cloud. This step is also known as Structure from Motion as explained earlier.

## Densify Point Cloud 
This step uses OpenMVS library to increase the number of points in the 3d point cloud generated using SfM. In effect, it densifies the sparse point cloud. This gives greater clarity and detail to the reconstruction. It first identifies the number of calibrated images i.e. the number of images which can be used for feature matching. Then using the known camera parameters like focal length and sensor width, it plots the feature points which couldn’t be located using the SfM algorithm. 

## Mesh Reconstruction
In this step, the vertices generated in the previous step are used to compute normals for triangular faces. This produces a mesh surface encompassing all the points of the dense point cloud.

## Mesh Refining 
The number of faces generated in the previous step are usually quite high if the image resolution is high. This increases the computation time for texturing the mesh and also the size of the file. To reduce the number of faces, the mesh is decimated and unwanted areas of the mesh are removed.

## Texturing
The texture information of the object is stored in a .png file and is applied onto the white coloured mesh to give it colour. Hence, the final output .ply file is obtained.
