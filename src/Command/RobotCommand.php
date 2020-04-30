<?php
/**
 * @author Malli 
 * @copyright 2020 Valuelabs
 */

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use App\Robot\RobotClean;

/**
 * Command control
 */
class RobotCommand extends Command {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Command configuration
     */
    protected function configure() {
        $this->setName('clean')
            ->setDescription('Robot for hoovering.')
            ->setHelp('Robot for hoovering that can charge itself.')
            ->addOption(
                'floor',
                NULL,
                InputOption::VALUE_REQUIRED,
                'Type of floor.'
            )
            ->addOption(
                'area',
                NULL,
                InputOption::VALUE_REQUIRED,
                'Area in meter squared.'
            );
    }

    /**
     * Execute command
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null|void
     * @throws \Exception
     */
    public function execute(InputInterface $input, OutputInterface $output) {
        $this->hoover($input, $output);
    }

    /**
     * Hoover Output and sleeping
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @throws \Exception
     */
    protected function hoover(InputInterface $input, OutputInterface $output) {
        $output->writeln([
            '**** Robot Floor Clean App ****',
            '==========================================',
            '',
        ]);
        $floor = $input->getOption('floor');
        $area = $input->getOption('area');
        $isFloorValid = $this->isFloorTypeValid($floor);
        $isAreaValid = $this->isAreaValid($area);
        $floorMessage = ($isFloorValid) ? "" : " - not valid";
        $areaMessage = ($isAreaValid) ? "" : " - not valid";

        $output->writeln("Floor Type: " . $floor . $floorMessage);
        $output->writeln("Area: " . $area . $areaMessage);
        $output->writeln('==========================================');

        if ($isFloorValid and $isAreaValid) {
            $robot = new RobotClean($input->getOption('floor'), floatval($input->getOption('area')));
            $tasks = $robot->run();
            foreach ($tasks as $taskType => $taskTime) {
                $output->writeln($taskType . ": " . $taskTime . "s");
                sleep(intval($taskTime));
            }
        }
        return 1;
    }

    /**
     * Check floor is valid or not
     * @param string $name
     * @return bool
     */
    private function isFloorTypeValid($floorType) {
        if (array_key_exists($floorType, RobotClean::FLOOR_TYPES)) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    /**
     * Check area is valid  or not
     * @param int $name
     * @return bool
     */
    private function isAreaValid($area) {
        if (is_numeric($area) and $area > 0) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
}